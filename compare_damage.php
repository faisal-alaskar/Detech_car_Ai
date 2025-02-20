<?php

function parse_damage_summary($damage_text) {
    $damage_list = [];
    $lines = explode("\n", trim(str_replace("Damage Summary:", "", $damage_text)));

    foreach ($lines as $line) {
        $line = trim($line);
        if (!empty($line)) {
            preg_match('/(Front View|Back View|Left Side View|Right Side View): (.+)/i', $line, $matches);
            if ($matches) {
                $view = strtolower(trim($matches[1]));
                $damages = explode(", ", trim($matches[2])); // تقسيم الأضرار المتعددة في السطر

                foreach ($damages as $damage) {
                    preg_match('/(\d+) /', $damage, $damage_match);
                    if ($damage_match) {
                        $count = intval($damage_match[1]);

                        if (!isset($damage_list[$view])) {
                            $damage_list[$view] = 0;
                        }
                        $damage_list[$view] += $count;
                    }
                }
            }
        }
    }
    return $damage_list;
}

function compare_damages($damage_before, $damage_after) {
    $new_damages = [];
    foreach ($damage_after as $view => $count) {
        $before_count = $damage_before[$view] ?? 0;
        if ($count > $before_count) {
            $new_count = $count - $before_count;
            $new_damages[] = ucfirst($view) . ": $new_count new damage(s)";
        }
    }
    return $new_damages;
}

// استقبال القيم من الطلب عبر `POST`
$damage_before_text = isset($_POST['damage_before']) ? $_POST['damage_before'] : "";
$damage_after_text = isset($_POST['damage_after']) ? $_POST['damage_after'] : "";

// ** التحقق من أن البيانات ليست فارغة **
if (empty($damage_before_text) || empty($damage_after_text)) {
    echo json_encode(["error" => "Missing damage_before or damage_after"]);
    exit;
}

// ** تحليل البيانات المخزنة **
$damage_before_parsed = parse_damage_summary($damage_before_text);
$damage_after_parsed = parse_damage_summary($damage_after_text);

// ** مقارنة الأضرار الجديدة فقط **
$new_damages = compare_damages($damage_before_parsed, $damage_after_parsed);

// ** طباعة بيانات التصحيح لمعرفة أين المشكلة **
header('Content-Type: application/json');
echo json_encode([
    "debug_damage_before" => $damage_before_parsed,
    "debug_damage_after" => $damage_after_parsed,
    "new_damages" => $new_damages
]);
