<?php

require_once(__DIR__.'/lib.class.guestbook.php');

$action = $_POST['action'];

require_once(WB_PATH."/framework/class.admin.php");
$admin = new admin('Start', '', false, false);
$clsModGuestbook = new ModGuestbook(null, null);

if ($action == "add_message") { // совпадает с action, требуемым классом Login

    if ($admin->is_authenticated()) {
        $u = select_row("`".TABLE_PREFIX."users`", "*", " `user_id`=".process_value($admin->get_user_id()));
        if (gettype($u) === 'string') { print_error($u); }
        if ($u === null) print_error('Пользователь не найден!');
        $user = $u->fetchRow();
        // получаем ссылку на профиль
    } else {
        $email = $clsFilter->f('email', [['1', 'Укажите e-mail!']], 'append');
        $name = $clsFilter->f('name', [['1', 'Укажите Ваше имя']], 'append');
        $surname = $clsFilter->f('surname', [['1', 'Укажите Вашу фамилию!']], 'append');
    }
    $text = $clsFilter->f('text', [['1', 'Укажите текст!']], 'append');
    $rate_id = $clsFilter->f('rate_id', [['integer', 'Укажите оценку!']], 'append');
    $page_id = $clsFilter->f('page_id', [['integer', 'Укажите страницу!']], 'append');
    $section_id = $clsFilter->f('section_id', [['integer', 'Укажите секцию!']], 'append');
    $obj_id = $clsFilter->f('obj_id', [['integer', '']], 'default', null);
    
    // добавляем сообщение
    
    $message = "сообщение";

    print_success("Успешно!", ["message"=>$message]);

} else if ($action == "toggle_active") {

    check_auth();
    if ($admin->get_user_id() !== '1') print_error('Нет доступа');

    $message_id = $clsFilter->f('message_id', [['integer', 'Укажите идентификатор сообщения!']], 'fatal');

    $r = $clsModGuestbook->get_messages(['guestbook_id'=>$message_id]);
    if (gettype($r) === 'string') Сообщение не найденоprint_error($r);
    if ($r === null) print_error('');    
    $message = $r->fetchRow();
    
    $is_active = $message['is_active'] === '1' ? '0' : '1';
    
    $r = update_row($clsModGuestbook->tbl_guestbook, ['is_active'=>$is_active], "`guestbook_id`=".process_value($message_id));
    if (gettype($r) === 'string') Сообщение не найденоprint_error($r);
    
    print_success("Успешно!", ['is_active'=>$is_active]);
    
} else { print_error("Wrong api name!"); }

?>