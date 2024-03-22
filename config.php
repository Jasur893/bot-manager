<?php
session_start();
date_default_timezone_set('Asia/Tashkent');

const API_KEY = "api key";

// admin akkaunti id raqamini ushbu bot orqali bilishingiz mumkin @infomiruz_idbot
$admin = "admin id";
$system_pass = '123';
$my_group =   "my group id"; // assosiy superGroup
$my_channel = "my channel id"; // kanallarda oldiga -100 raqamini qo'shish kerak
$logging = true;
$fallows = [
    [
        'text_btn' => "👍 Ozimizning guruh",
        'chat_id' => $my_group,
        'link' => "link",
        'required' => false
    ],
    [
        'text_btn' => "👍 Bizning Kanal",
        'link' => "link", // invite_link
        'chat_id' => $my_channel,
        'required' => true
    ],
    [
        'text_btn' => "👉 Bizning Guruh 👈",
        'link' => "link",
        'chat_id' => 'channel or group id',
        'required' => true  // bot admin emas, obuna bolganmi, yo'qmi, majbur emas foydalanuvchi
    ]
];

$fallow_time = 24; // majburiy obunalarni tekshirish intervali soatlarda korsating
$share_btn = [
    'share_btn' => "Do'stlarni taklif qilish 👨🏿‍🤝‍👨🏾",
    'share_text' => "😍😎 Salom, biz dostlarimiz bilan yangi guruhda, sovgalar oyinini tashkil etdik, omadingizni sinab kormaysizmi ?!",
    'share_link' => "share link group or channel"
];
$db_mysql  = [
    'status' => true,
    'host' => "localhost",
    'name' => "cmhosting_bot",
    'user' => "root",
    "pass" => ""
];
$comands = [
    [
        'commands' => json_encode([ // faqat bot va admin chati uchun
            ['command' => "/info", 'description' => "Bot faoliyati haqida."],
            ['command' => "/top", 'description' => "Takliflar boyicha natijalar."],
            ['command' => "/newfile", 'description' => "Yangi fayl yuklash."],
            ['command' => "/mycloud_photo", 'description' => "Mening barcha photolarim."],
            ['command' => "/mycloud_audio", 'description' => "Mening barcha audio filelarim."],
            ['command' => "/mycloud_video", 'description' => "Mening barcha video filelarim."],
            ['command' => "/mycloud_document", 'description' => "Mening barcha documentlarim."],
        ]),
        'scope' => json_encode([
            'type' => "chat",
            'chat_id' => $admin
        ])
    ],
    [
        'commands' => json_encode([ // guruhlarda adminlar uchun
            ['command' => "/ban", 'description' => "Qatnashchiga ban berish, reply /ban."],
            ['command' => "/mute", 'description' => "Foydalanuvchini cheklash, reply 10 minut."],
            ['command' => "/money", 'description' => "Valyuta kurslarini olish."],
            ['command' => "/top", 'description' => "Takliflar boyicha yetakchilar, + 3...100"],
            ['command' => "/game", 'description' => "Tasodifiy o'yin boshlash."],
            ['command' => "/stop", 'description' => "Chatni yopib qoyish."],
            ['command' => "/start", 'description' => "Chatni ishga tushirish."],
        ]),
        'scope' => json_encode([
            'type' => "all_chat_administrators"
        ])
    ],
    [
        'commands' => json_encode([ // barcha gurudagi foydalanuvchilar uchun, biz ko'rsatgan guruhda amal qiladi
            ['command' => "/top", 'description' => "Takliflar boyicha yetakchilar."],
            ['command' => "/game", 'description' => "Tasodifiy o'yin boshlash."],
            ['command' => "/money", 'description' => "Valyuta kurslarini olish."],
        ]),
        'scope' => json_encode([
            'type' => "all_group_chats"
        ])
    ],
    [
        'commands' => json_encode([ // bot va foydalanuvchilar uchun
            ['command' => "/start", 'description' => "Bot haqida malumot."],
            ['command' => "/game", 'description' => "Bot bilan o'yin oynash."],
            ['command' => "/myscore", 'description' => "Mening ballarim."],
        ]),
        'scope' => json_encode([
            'type' => "all_private_chats"
        ])
    ]
];

$dices = ["🎲", "🎯", "🎳", "🏀", "⚽", "🎰"];