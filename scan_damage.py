import sys
import requests
import json
from PIL import Image, ImageDraw, ImageFont
import os

sys.stdout.reconfigure(encoding='utf-8')

# مفاتيح الـ API
#هذي مفاتيح ربط وممكن مع الزمن لاتشتغل يمكنك تبديلها بمفاتيحك الخاصه للمودل حقك
scratch_detection_api_key = "CkZpS8to9cLyNSNKmXsY"
car_detection_api_key = "91ffAsJwgfYqrmux0tGY"

# مسار حفظ الصور المعدلة
# add your path
output_dir = "add your path"

# إنشاء المجلد إذا لم يكن موجودًا
if not os.path.exists(output_dir):
    os.makedirs(output_dir)

def analyze_car(image_path):
    """ تحليل الصورة لاكتشاف السيارة """
    try:
        with open(image_path, 'rb') as img:
            response = requests.post(
                f"https://detect.roboflow.com/car-detection-gp2/1?api_key={car_detection_api_key}&confidence=0.3",
                files={"file": img}
            )
            response.raise_for_status()
            result = response.json()
            print(f"\n Total cars detected: {len(result['predictions'])}")
            return result
    except Exception as e:
        print(f" Error detecting car: {e}")
        return None

def analyze_damage(image_path):
    """ تحليل الصورة لاكتشاف الأضرار """
    try:
        with open(image_path, 'rb') as img:
            response = requests.post(
                f"https://detect.roboflow.com/car-damage-detection-mwbgo/1?api_key={scratch_detection_api_key}&confidence=0.1",
                files={"file": img}
            )
            response.raise_for_status()
            result = response.json()
            print(f"\n Total damages detected: {len(result['predictions'])}")
            return result
    except Exception as e:
        print(f" Error detecting damage: {e}")
        return None

def is_damage_inside_car(damage, car):
    """ التحقق مما إذا كان الضرر داخل السيارة """
    damage_x, damage_y = damage["x"], damage["y"]
    car_left = car["x"] - car["width"] / 2
    car_right = car["x"] + car["width"] / 2
    car_top = car["y"] - car["height"] / 2
    car_bottom = car["y"] + car["height"] / 2

    return car_left <= damage_x <= car_right and car_top <= damage_y <= car_bottom

def draw_predictions(image_path, car_predictions, damage_predictions):
    """ رسم مربعات السيارات والضرر داخل السيارات فقط """
    try:
        # فتح الصورة الأصلية
        image = Image.open(image_path)
        draw = ImageDraw.Draw(image)

        # تحميل خط كبير للنصوص
        try:
            car_font = ImageFont.truetype("arial.ttf", 40)  # خط السيارة
            damage_font = ImageFont.truetype("arial.ttf", 30)  # خط الضرر
        except IOError:
            car_font = ImageFont.load_default()
            damage_font = ImageFont.load_default()

        #  تجميع تقرير الأضرار لكل موقع (Front, Back, Left, Right)
        damage_summary = {
            "Front View": {"Scratch": 0, "Dent": 0, "Broken part": 0},
            "Back View": {"Scratch": 0, "Dent": 0, "Broken part": 0},
            "Left Side View": {"Scratch": 0, "Dent": 0, "Broken part": 0},
            "Right Side View": {"Scratch": 0, "Dent": 0, "Broken part": 0},
        }

        #  رسم الأضرار داخل السيارات فقط
        for damage in damage_predictions:
            if any(is_damage_inside_car(damage, car) for car in car_predictions):
                x, y, width, height = damage["x"], damage["y"], damage["width"], damage["height"]
                left, top = x - width / 2, y - height / 2
                right, bottom = x + width / 2, y + height / 2

                damage_type = damage["class"]
                color = "red" if damage_type == "Scratch" else "blue"
                draw.rectangle([left, top, right, bottom], outline=color, width=5)

                #  معرفة موقع الضرر بناءً على الإحداثيات
                if x < image.width * 0.25:
                    view = "Left Side View"
                elif x > image.width * 0.75:
                    view = "Right Side View"
                elif y < image.height * 0.3:
                    view = "Front View"
                else:
                    view = "Back View"

                #  زيادة عدد الأضرار لكل موقع
                if damage_type in damage_summary[view]:
                    damage_summary[view][damage_type] += 1

                #  كتابة نوع الضرر بدون نسبة الثقة
                text_label = f"{damage_type}"
                text_x, text_y = left, top - 35
                draw.rectangle([text_x, text_y, text_x + 120, text_y + 30], fill="white")  # خلفية النص
                draw.text((text_x + 5, text_y + 5), text_label, fill=color, font=damage_font)

        #  طباعة تقرير الأضرار المفصّل
        print("\n Damage Report:")
        for view, damages in damage_summary.items():
            report_line = f"{view}: " + ", ".join([f"{count} {dtype}(s)" for dtype, count in damages.items() if count > 0])
            if any(count > 0 for count in damages.values()):
                print(report_line)

        #  حفظ الصورة المعدلة
        filename = os.path.basename(image_path)
        modified_image_path = os.path.join(output_dir, f"modified_{filename}")
        image.save(modified_image_path)
        print(f" Processed image saved at: {modified_image_path}")
        return modified_image_path

    except Exception as e:
        print(f" Error drawing predictions: {e}")
        return None


def detect_damage(image_path):
    """ اكتشاف السيارة ثم تحليل الضرر داخلها فقط """
    car_result = analyze_car(image_path)
    damage_result = analyze_damage(image_path)

    if not car_result or "predictions" not in car_result or not car_result["predictions"]:
        print(f" No cars detected in {image_path}. Skipping damage detection.")
        return None

    car_predictions = car_result["predictions"]

    if not damage_result or "predictions" not in damage_result:
        print(f" No damage detected for {image_path}.")
        return None

    damage_predictions = damage_result["predictions"]

    print(f" Filtering damages inside detected cars...")
    return draw_predictions(image_path, car_predictions, damage_predictions)

#  التشغيل الرئيسي
if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(" No image path provided. Exiting...")
        sys.exit(1)

    image_path = sys.argv[1]

    try:
        modified_image = detect_damage(image_path)
        if modified_image:
            print(f" Modified image saved at: {modified_image}")
            print(modified_image)  #  إعادة المسار للموقع
        else:
            print(" No Damage Detected.")
    except Exception as e:
        print(f" An error occurred: {e}")
