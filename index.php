<!DOCTYPE html>
<!--атрибут lang определяет язык содержимого элемента.-->
<html lang="ru">

<!--метаданные-->

<head>
	<!--данная запись указывает браузеру кодировку в которой была написана данная страница - формат документа и раскладку клавиатуры-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--призывает Internet Explorer работать в определённом режиме документа-->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--мeta-тег viewport сообщает браузеру о том, как именно обрабатывать размеры страницы, и изменять её масштаб-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--определяет заголовок документа, который отображается в заголовке окна браузера или на вкладке страницы.-->
	<title>12.6</title>
	<!--подключение файла стилей-->
	<link rel="stylesheet" type="text/css" href="style.css" media="all">
</head>

<!--тело документа-->

<body>
	<!--самый симпатичный вариант оформления массива получился с таким использованием переноса-->
	<?php $example_persons_array = [
		[ 'fullname'=> 'Иванов Иван Иванович',
		'job' => 'tester <br><hr>',
		],
		[ 'fullname'=> 'Степанова Наталья Степановна',
		'job' => 'frontend-developer <br><hr>',
		],
		[ 'fullname'=> 'Пащенко Владимир Александрович',
		'job' => 'analyst <br><hr>',
		],
		[
		'fullname' => 'Громов Александр Иванович',
		'job' => 'fullstack-developer <br><hr>',
		],
		[
		'fullname' => 'Славин Семён Сергеевич',
		'job' => 'analyst <br><hr>',
		],
		[
		'fullname' => 'Цой Владимир Антонович',
		'job' => 'frontend-developer <br><hr>',
		],
		[
		'fullname' => 'Быстрая Юлия Сергеевна',
		'job' => 'PR-manager <br><hr>',
		],
		[
		'fullname' => 'Шматко Антонина Сергеевна',
		'job' => 'HR-manager <br><hr>',
		],
		[
		'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
		'job' => 'analyst <br><hr>',
		],
		[
		'fullname' => 'Бардо Жаклин Фёдоровна',
		'job' => 'android-developer <br><hr>',
		],
		[
		'fullname' => 'Шварцнегер Арнольд Густавович',
		'job' => 'babysitter <br>',
		]
		];


		//Принимает как аргумент три строки — фамилию, имя и отчество. Возвращает как результат их же, но склеенные через	пробел
		function getFullnameFromParts($surname, $name, $patronymic)
		{
		return $surname ."\x20" . $name . "\x20" . $patronymic;
		}

		//Принимает как аргумент одну строку — склеенное ФИО. Возвращает как результат массив из трёх элементов с ключами	name, surname и patronymic
		function getPartsFromFullname($fullName)
		{
		$chunkName = [];
		$startNum = 0;
		//Получаем длину строки
		$strLen = mb_strlen($fullName);
		//Ищем вхождение пробела и добавляем в массив
		for ($i = 0; $i < $strLen; $i++) {
			 //Пишем услвие равенства десятичного код символа в указанной части строки 
			 if (mb_ord(mb_substr($fullName, $i, 1))==32) { 
				//Проверяем, присутствует ли в массиве нужный ключ, найденный с помощью mb_substr 
				array_key_exists('surname', $chunkName) ? $chunkName['name']=mb_substr($fullName, $startNum,	$i - $startNum) : $chunkName['surname']=mb_substr($fullName, $startNum, $i - $startNum); 
				$startNum=$i + 1; }
			//После последнего пробела
			 if ($i==$strLen - 1 && $startNum> 0) {
			//Проверяем, присутствует ли в массиве нужный ключ, найденный с помощью mb_substr
			array_key_exists('name', $chunkName) ? $chunkName['patronymic'] = mb_substr($fullName, $startNum) : $chunkName['Name'] = mb_substr($fullName, $startNum);
			}
			}
			return $chunkName;
			}

			//Принимает как аргумент строку, содержащую ФИО вида «Иванов Иван Иванович» и возвращающую строку вида «Иван И.»,	где сокращается фамилия и отбрасывается отчество
			function getShortName($fullName)
			{
			$nameParts = getPartsFromFullname($fullName);
			return $nameParts['surname'] . "\x20" . mb_substr($nameParts['name'], 0, 1) . ".";
			}

			//Принимает как аргумент строку, содержащую ФИО (вида «Иванов Иван Иванович») и возвращает пол
			function getGenderFromName($fullName)
			{
			$nameParts = getPartsFromFullname($fullName);
			$male = 0;
			$female = 0;
			//условие проверки окончания фамилии в указанной части строки
			if (mb_substr($nameParts['surname'], -1) == 'в')
			//счетчик для мужского пола
			$male += 1;
			elseif (mb_substr($nameParts['surname'], -2) == 'ва')
			//счетчик для женского пола
			$female += 1;
			//----------------------
			//условие проверки окончания имени в указанной части строки
			if (mb_substr($nameParts['name'], -1) == 'й' || mb_substr($nameParts['name'], -1) == 'н')
			//счетчик для мужского пола
			$male += 1;
			elseif (mb_substr($nameParts['name'], -1) == 'а')
			//счетчик для женского пола
			$female += 1;
			//----------------------
			//условие проверки окончания отчества в указанной части строки
			if (mb_substr($nameParts['patronymic'], -2) == 'ич')
			//счетчик для мужского пола
			$male += 1;
			elseif (mb_substr($nameParts['patronymic'], -3) == 'вна')
			//счетчик для женского пола
			$female += 1;
			//возврат результата с применением оператора комбинированного сравнения
			return $male <=> $female;
				}

				/*Определения полового состава аудитории. Как аргумент в функцию передается массив.Как результат функции
				возвращается информация в следующем виде
				Гендерный состав аудитории:
				---------------------------
				Мужчины - 55.5%
				Женщины - 35.5%
				Не удалось определить - 10.0% */
				function getGenderDescription($auditory)
				{
				$results;
				$maleResult = 0;
				$femaleResult = 0;
				$undefinedResult = 0;
				//перебираем массив, задаваемый с помощью $auditory. На каждой итерации значение текущего элемента	присваивается переменной $person
				foreach ($auditory as $person) {
				$results[] = getGenderFromName($person['fullname']);
				}
				//подсчет числа и условие, соответствующее мужчинам
				echo "Мужчины - " . round(count(array_filter($results, function ($num) {
				if ($num == 1)
				return true;
				else
				return false;
				})) / count($results), 2) . '%' . '<br>';
				;
				//подсчет числа и условие, соответствующее женщинам
				echo "Женщины - " . round(count(array_filter($results, function ($num) {
				if ($num == -1)
				return true;
				else
				return false;
				})) / count($results), 2) . '%' . '<br>';
				;
				//подсчет числа и услови енеопределенного пола
				echo "Неудалось определить - " . round(count(array_filter($results, function ($num) {
				if ($num == 0)
				return true;
				else
				return false;
				})) / count($results), 2) . '%' . '<br>';
				;
				}

				//Определения «идеальной» пары. Как первые три аргумента в функцию передаются строки с фамилией, именем и отчеством (именно в этом порядке). При этом регистр может быть любым: ИВАНОВ ИВАН ИВАНОВИЧ, ИваНов Иван	иванович. Как четвертый аргумент в функцию передается массив
				function getPerfectPartner($surname, $name, $patronymic, $auditory)
				{
				//c помощью mb_convert_case производим смену регистра символов в строке. склеиваем ФИО, используя функцию getFullnameFromParts
				$normalisedName = getFullnameFromParts(mb_convert_case($surname, MB_CASE_TITLE), mb_convert_case($name,	MB_CASE_TITLE), mb_convert_case($patronymic, MB_CASE_TITLE));
				// указываем соотвествующий подсчетам пол
				$curGender = getGenderFromName($normalisedName);
				$pairPerson = null;
				// генератор рандомного числа
				do {
				$pairPerson = $auditory[rand(0, count($auditory) - 1)];
				//проверяем с помощью getGenderFromName, что выбранное из Массива ФИО - противоположного пола, если нет, то	возвращаемся к шагу 4, если да - возвращаем информацию.
				if (getGenderFromName($pairPerson['fullname']) == $curGender)
				$pairPerson = null;
				} while ($pairPerson == null);
				echo getShortName($normalisedName) . '+' . getShortName($pairPerson['fullname']) . '=' . '<br>';
				// результат
				echo "♡ Идеально на " . rand(50, 100) . "% ♡" . '<br>';
				;
				}

				//===============================================================

				echo '<div style="font-size:25px; font-weight:bolt; text-decoration:underline; color:purple">Исходный
					массив:'.'</div>';
				echo '<br>';
				// print_r($example_persons_array);
				print_r($example_persons_array);
				echo '<br>
				<hr>';
				$fullName = $example_persons_array[0]['fullname'];
				echo '<br>';
				echo '<div style="font-size:20px; color:purple">Исходное полное имя:'.'</div> <br>' . $fullName . '<br>';
				echo '<br>
				<hr>';
				$chunckedName = getPartsFromFullname($example_persons_array[0]['fullname']);
				echo '<br>';
				echo '<div style="font-size:20px; color:purple">Результат работы getPartsFromFullname:'.'</div><br>';
				print_r($chunckedName);
				echo '<br>';
				echo '<br>
				<hr>';
				echo '<br>';
				echo '<div style="font-size:20px; color:purple">Результат работы getPartsFromFullname:'.'</div><br>' .
				getFullnameFromParts($chunckedName['surname'],
				$chunckedName['name'], $chunckedName['patronymic']) . '<br>';
				echo '<br>
				<hr>';
				echo '<br>';
				echo '<div style="font-size:20px; color:purple">Результат работы getShortName:'.'</div><br>' . getShortName($fullName) .
				'<br>';
				echo '<br>';
				echo '<br>
				<hr>';
				echo '<div style="font-size:20px; color:purple">Результат работы getGenderFromName:'.'</div><br>' .
				getGenderFromName($fullName) . '<br>';
				echo '<br>';
				echo '<br>
				<hr>';
				echo '<div style="font-size:20px; color:purple">Соотношение полов:'.'</div><br>' . getShortName($fullName) . '<br>';
				getGenderDescription($example_persons_array);
				echo '<br>';
				?>
</body>

</html