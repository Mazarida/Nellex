<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$APPLICATION->SetTitle("Авторизация");

if ($USER->IsAuthorized()) {
	LocalRedirect(PATH_TO_PERSONAL);
}
?>

	<div class="content__wrapper-reg">
		<div class="flex-row login-reg">
			<div class="col__login">
				<div class="loginreg__head">Вход</div>
				<?
				$APPLICATION->IncludeComponent("bitrix:system.auth.form", "main", Array(
					"FORGOT_PASSWORD_URL" => PATH_TO_RECOVERY_PASSWORD,	// Страница забытого пароля
					"PROFILE_URL" => PATH_TO_PERSONAL,	// Страница профиля
					"REGISTER_URL" => PATH_TO_AUTH,	// Страница регистрации
					"SHOW_ERRORS" => "Y",	// Показывать ошибки
				),
					false
				);
				?>
			</div>
			<div class="col__reg">
				<div class="loginreg__head">Регистрация</div>
				<?
				$APPLICATION->IncludeComponent("bitrix:main.register", "main", Array(
					"AUTH" => "Y",	// Автоматически авторизовать пользователей
					"REQUIRED_FIELDS" => array(	// Поля, обязательные для заполнения
						0 => "NAME",
						1 => "LAST_NAME",
						2 => "SECOND_NAME",
						3 => "UF_INN",
						4 => "EMAIL",
						5 => "PERSONAL_PHONE",
						6 => "PERSONAL_CITY",
						7 => "PERSONAL_STREET",
						//7 => "UF_STREET",
						8 => "PERSONAL_ZIP",
						//9 => "UF_HOUSE",
						//10 => "UF_CORPSE",
						//11 => "UF_APARTMENTS",
					),
					"SET_TITLE" => "N",	// Устанавливать заголовок страницы
					"SHOW_FIELDS" => array(	// Поля, которые показывать в форме
						0 => "NAME",
						1 => "LAST_NAME",
						2 => "SECOND_NAME",
						3 => "UF_INN",
						4 => "EMAIL",
						5 => "PERSONAL_PHONE",
						6 => "PERSONAL_CITY",
						7 => "PERSONAL_STREET",
						//7 => "UF_STREET",
						8 => "PERSONAL_ZIP",
						//9 => "UF_HOUSE",
						//10 => "UF_CORPSE",
						//11 => "UF_APARTMENTS",
					),
					"SUCCESS_PAGE" => PATH_TO_PERSONAL,	// Страница окончания регистрации
					"USER_PROPERTY" => "",	// Показывать доп. свойства
					"USER_PROPERTY_NAME" => "",	// Название блока пользовательских свойств
					"USE_BACKURL" => "N",	// Отправлять пользователя по обратной ссылке, если она есть
				),
					false
				);
				?>
			</div>
		</div>
	</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>