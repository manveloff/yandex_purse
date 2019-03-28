# Парсинг текста из СМС сервиса Яндекс.Деньги

## Задача
Для подтверждения операций в Яндекс.Кошельке требуется
вводить код из СМС. Можно настроить свой телефон, чтобы
он отправлял текст из СМС в ваш сервис, там это текст
парсить, и извлекать код, сумму и номер кошелька.

## Решение

### PHP-функция для парсинга данных из СМС
```
$parse = function($str){
        
  preg_match_all('#(?<![\d])\d{4}(?![рР\d])#miu', $str, $code);
  preg_match_all('#(\d{1,},\d{1,}[рР]|\d{1,}[рР])#miu', $str, $sum);
  preg_match_all('#\d{11,}#miu', $str, $purse);
  return [
    'code'  => $code[0][0],
    'sum'   => $sum[0][0],
    'purse' => $purse[0][0],
  ];

};
```

P.S. Номер кошелька ещё можно прогонять через валидатор Яндекс.Кошельков, например, этот (https://github.com/Olegf13/check_yandex_purse), но я не стал копировать и  применять код его функции в решение, чтобы не загромождать. Вы можете сделать это самостоятельно.


### Протестированные примеры текстов из СМС
```
"Пароль: 4258
Спишется 503,52р.
Перевод на счет 410011435701025"

"Пароль: 9116
Спишется 100р.
Перевод на счет 4100112345678"

"Пароль: 5117
Спишется 1000р.
Перевод на счет 4100112345678"

"Пароль: 4258Спишется 503,52р.Перевод на счет 410011435701025"

"Пароль: 5117Спишется 1000р.Перевод на счет 4100112345678"
```

Анализ задачи
-------------
```
1. На что нельзя опираться
- Порядок полей
- Пунктуация
- Слова

2. Валидация номера кошелька
Кошелек состоит минимум из 11 цифр. Ищем в тексте число из >= 11 цифр,
и скармливаем его валидатору яндекс.кошелька 
(https://github.com/Olegf13/check_yandex_purse), берем первый успешный
результат.

Регулярка: 
\d{11,}

3. Валидация суммы
Сумма, это строка, начинающаяся с числа, и заканчивающаяся буквой р.
Кроме этой буквы "р" в конце не вижу другого способа отличить сумму от пароля.

Регулярка:
(\d{1,},\d{1,}[рР]|\d{1,}[рР])

4. Валидация пароля
Пароль, это строка, состоящая из 4 цифр, после которой не стоит "р", и 
перед которой нет других цифр.

Регулярка:
(?<![\d])\d{4}(?![рР\d])
```





