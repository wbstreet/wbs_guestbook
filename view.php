<?php

include(__DIR__.'/lib.class.guestbook.php');
$clsModGuestbook = new ModGuestbook($page_id, $section_id);

$is_auth = false;
if ($admin->is_authenticated()) {$is_auth = true;}

$is_admin = false;
if ($admin->get_user_id() == 1) {$is_admin = true;}

$obj_id = _GET['obj_id'] ?? null;
if ($obj_id !== null) $obj_id = preg_replace("/[^0-9]+/", '', $obj_id);
if ($obj_id === '') $obj_id = null;

$messages = [];
$sets = [];
if (!$is_admin) $sets['is_active'] = '1';
$r = $clsModGuestbook->get_messages($sets);
if (gettype($r) === 'string') { $clsModGuestbook->print_error($r); $r = null; }
while ($r !== null && $row = $r->fetchRow()) {

    $row['user'] = [];
    if ($row['user_id'] !== null) {
        $u = select_row("`".TABLE_PREFIX."users`", "*", " `user_id`=".process_value($row['user_id']));
        if (gettype($u) === 'string') { $clsModGuestbook->print_error($u); }
        else if ($u !== null) {
            $row['user'] = $u->fetchRow();
            // получаем ссылку на профиль
        }
    }

    $messages[] = $row;
}

$rates = [];
$r = select_row($clsModGuestbook->tbl_guestbook_rate, "*", " `rate_is_active`=1 ORDER BY `rate_position`");
if (gettype($r) === 'string') { $clsModGuestbook->print_error($r); $r = null; }
while ($r !== null && $row = $r->fetchRow()) { $rates[] = $row; }

$clsModGuestbook->render('view.html', [
    'messages'=>$messages,
    'rates'=>$rates,
    'is_auth'=>$is_auth,
    'is_admin'=>$is_admin,
    'spo'=>"page_id:'{$page_id}',section_id:'{$section_id}',obj_id:'{$obj_id}'",
]);

?>