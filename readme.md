# Тестова нейронна мережа на PHP

Нейронна мереже (багатошаровий перцептрон), яка навчається за допомогою метода зворотнього розповсюдження помилки. Написана в тестових цілях, для задоволення.

## Вимоги
    * >= PHP7.0
   
## Установка

```bash
composer dumpautoload
```

## Запустити

```php
php index.php
```

## Як користуватись?

Всі налаштування мережі знаходяться у файлі **index.php**

#### Створення мережі:

```php
$layers = [3, 40, 1];
$neuralNetwork = new NeuralNetwork($layers);
```

Параметри мережі $layers, означають наступне:
* 3 нейрони вхідного шару
* 40 нейронів внутрішнього шару
* 1 нейрон вихідного шару.

_Примітка: Немає сенсу створювати мережу більше ніж з 2 внутрішніми шарами._

#### Тренування мережі

Для тренування мережі потрібно вказати кількість епох **$epoch**, тобто те скільки раз мережа буде перебирати дані для навчання і швидкість навчання **$learningRate**. Ці параметри підбираються емпіричним методом. 

А також потрібно вказати дані для навчання. Де **'input'** містить вхідні данні. Кількість має збігатися із кількістю нейронів у вхідному шарі. І **'output'**, де аналогіно, кількість повинна збігатись із кількістю нейронів у вихідному шарі.

```php
$epoch = 10000;
$learningRate = 0.02;
$train = [
    [
        'input'  => [0, 0, 1],
        'output' => [1],
    ],
    [
        'input'  => [0, 1, 0],
        'output' => [1],
    ],
    [
        'input'  => [0, 1, 1],
        'output' => [0],
    ],
    [
        'input'  => [1, 0, 0],
        'output' => [1],
    ],
    [
        'input'  => [1, 0, 1],
        'output' => [0],
    ],
    [
        'input'  => [1, 1, 0],
        'output' => [0],
    ],
    [
        'input' => [1, 1, 1],
        'output' => [0],
    ],
];

$neuralNetwork->train($epoch, $learningRate, $train, DEBUG);
```

Результати роботи навченої мережі:

[вхідні дані] => [вихідні дані] (Приведені до булевого значення)

```
1. [0, 0, 1] => [0.93049602343984] (1)
2. [0, 1, 0] => [0.93086095530334] (1)
3. [0, 1, 1] => [0.044006863171877] (0)
4. [1, 0, 0] => [0.92944985955907] (1)
5. [1, 0, 1] => [0.045293990455669] (0)
6. [1, 1, 0] => [0.045576255991116] (0)
7. [1, 1, 1] => [0.0052511590540905] (0)
```