 **DETECH: AI-Powered Car Inspection Tool 🚗🔍**

DETECH is a smart car inspection system designed to enhance the car rental process by leveraging AI technology. The project uses an AI model developed on the **Roboflow** platform, integrated via **API keys**, without the need for a downloadable or modifiable model file.

The system is seamlessly connected to a **web application** and a **MySQL database**, providing a complete solution for car damage detection and rental management.

---

### **Setup & Installation Instructions 🛠️**

1. **Environment Setup:**  
   - Download the project files and install **XAMPP** to set up a local server.  
   - Place the project folder inside the `htdocs` directory in the XAMPP installation path.

2. **File Path Adjustments:**  
   - Update the image storage path in `scan_damage.py` to match your local directory:
     ```python
     output_dir = "your/local/path/to/save/images"
     ```
   - Update the database connection details in `db.php` with your local credentials.

3. **Python Script Configuration:**  
   In both `delivery_car.php` and `return_car.php`, modify the following lines to match your Python and project paths:
   ```php
   $python_path = "C:\\path\\to\\python.exe";  
   $script_path = "C:\\path\\to\\scan_damage.py";  
   ```

4. **Database Setup:**  
   - The project includes a **database file** inside the `database` folder.  
   - Import the `.sql` file into your MySQL environment using **phpMyAdmin** or the MySQL CLI.

---

### **Project Overview 🌟**
- **Frontend:** Web interface for users and admins.  
- **Backend:** PHP and MySQL for data management.  
- **AI Model:** Roboflow API for real-time damage detection.  
- **Database:** Structured schema for managing users, cars, and reservations.

---

### **Final Thoughts 💡**
We hope this project provides a smooth setup experience and inspires further development. **Best wishes for your future projects and innovations! 🚀**

---
