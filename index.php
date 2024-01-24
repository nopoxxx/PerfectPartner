<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Perfect Partner Finder</title>
</head>
<body>

<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
]; 

function getFullnameFromParts($surname, $name, $patronomyc) {
  $fullname = $surname . " " . $name . " " . $patronomyc;
  return $fullname;
}

function getPartsFromFullname($fullname) {
    $parts = explode(' ', $fullname);
    $result = [
        'surname' => $parts[0],
        'name' => $parts[1],
        'patronomyc' => $parts[2]
    ];
    return $result;
}

function getShortName($toShortName) {
        $parts = getPartsFromFullname($toShortName);
        $surname = mb_substr($parts['surname'], 0, 1);
        $name = $parts['name'];
        return $name . ' ' . $surname . '.';
}

function getGenderFromName($nameToGender) {
    $parts = getPartsFromFullname($nameToGender);
    $genderCount = 0;

    if (substr($parts['patronymic'], -6) == 'вна') {
        $genderCount -= 1;
    }
    
    if (substr($parts['name'], -2) == 'а') {
        $genderCount -= 1;
    }
    
    if (substr($parts['surname'], -4) == 'ва') {
        $genderCount -= 1;
    }

    if (substr($parts['patronymic'], -4) == 'ич') {
        $genderCount += 1;
    }
    
    if (in_array(substr($parts['name'], -2), ['й', 'н'])) {
        $genderCount += 1; 
    }
    
    if (substr($parts['surname'], -2) == 'в') {
        $genderCount += 1; 
    }
        if ($genderCount > 0) {
            return 'Male';
        } elseif ($genderCount < 0) {
            return 'Female';
        } else {
            return 0;
    }
}

function getGenderDescription($persons)
{
    $totalPersons = count($persons);
    $maleCount = 0;
    $femaleCount = 0;
    $unknownCount = 0;

    foreach ($persons as $person) {
        $gender = getGenderFromName($person['fullname']);   

        if ($gender === 'Male') {
            $maleCount++;
        } elseif ($gender === 'Female') {
            $femaleCount++;
        } else {
            $unknownCount++;
        }
    }

    $malePercentage = floor(($maleCount / $totalPersons) * 100);
    $femalePercentage = floor(($femaleCount / $totalPersons) * 100);
    $unknownPercentage = floor(($unknownCount / $totalPersons) * 100);

    return "
        Гендерный состав аудитории:
        Мужчины - $malePercentage%,
        Женщины - $femalePercentage%,
        Не удалось определить - $unknownPercentage%
    ";
}

function getPerfectPartner($lastname, $firstname, $patronymic, $persons) {
    $lastname = strtolower($lastname);
    $firstname = strtolower($firstname);
    $patronymic = strtolower($patronymic);

    $fullName = getFullnameFromParts($lastname, $firstname, $patronymic);
    $gender = getGenderFromName($fullName);

    while (true) {
        $randomPerson = $persons[array_rand($persons)];
        $randomGender = getGenderFromName($randomFullname);
        $randomShortName = getShortName($randomFullname);

        if ($randomGender != $gender) {
            break;
        }
    }

    $shortName = getShortName($fullName);

    return "$shortName + $randomFullname = \n♡ Идеально на " . rand(50, 100) . "% ♡";
}
?>
<span> <?php 

echo getPerfectPartner("Подгорный","Дмитрий","Евгеньевич", $example_persons_array)

?></span>

</body>
</html>