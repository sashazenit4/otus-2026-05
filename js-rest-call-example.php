<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

use Bitrix\Main\UI\Extension;

global $APPLICATION;
$APPLICATION->SetTitle('Пример вызова РЕСТ метода из коробки');

Extension::load(['restclient']);
?>
<form id="BOOK_ADD_FORM">
    <input type="text" name="title" value="КНИГА">
    <input type="submit">
</form>
<script>
    function showMessage(message) {
        alert(message);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('BOOK_ADD_FORM');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const bookTitle = document.querySelector('input[name="title"]')?.value;
            BX.rest.callMethod('otus.book.add', {
                'BOOK': {
                    'TITLE': bookTitle,
                }
            }, function(result) {
                if (result.error()) {
                    console.error(result.error());
                } else {
                    console.log('Идентификатор новой книги: ' + result.data());
                }
            });
        })
    });
</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
