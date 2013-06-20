<?php
/*
 * THEME WITHDRAWALS
 */
?>
<?php
global $wpdb;



if($_POST){
 $querystr = "SELECT * FROM " . $wpdb->prefix .THEME_NAME. "_withdrawals ORDER BY id DESC";
 $pageposts = $wpdb ->get_results($querystr, OBJECT);
$new_balance = ($_POST['user_balance']-$_POST['request_amount']);
echo $new_balance;
    foreach ($_POST['withdrawal_status'] as $key=>$value){
$wpdb->query(
	"
	UPDATE ".$wpdb->prefix .THEME_NAME. "_withdrawals
	SET payment_status = ".$value.", user_balance = ".$new_balance."
	WHERE ID = ".$key."
	"
);
    }
}


 $querystr = "SELECT * FROM " . $wpdb->prefix .THEME_NAME. "_withdrawals ORDER BY id DESC";
 $pageposts = $wpdb->get_results($querystr, OBJECT);
 $rows_total_count = count($pageposts);
 $rows_limit = 20;
 $page = @$_GET['transactions_page'];

 if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $rows_total_count)) {
      $page = 1;
 }

 $total_pages = ceil($rows_total_count / $rows_limit);
 $set_limit = $page * $rows_limit - ($rows_limit);

 $querystr = "SELECT * FROM " . $wpdb->prefix .THEME_NAME. "_withdrawals ORDER BY id DESC LIMIT ".$set_limit.",".$rows_limit;
 $pageposts = $wpdb ->get_results($querystr, OBJECT);

 ?>
<div class="wrap">
<h2>Withdrawals</h2>

<form id="new_post" name="withdrawal_post" method="post" action="" enctype="multipart/form-data">
<table class="widefat">
<thead>
    <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Requested Date</th>
        <th>Balance</th>
        <th>Request Amount</th>
        <th>PayPal Account</th>
        <th>Payment Status</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Requested Date</th>
        <th>Balance</th>
        <th>Request Amount</th>
        <th>PayPal Account</th>
        <th>Payment Status</th>
    </tr>
</tfoot>
<tbody>
<?php
@$post_count = 0;
foreach ($pageposts as $post){
    if($post->payment_status != 0){
        $pending = '';
        $payed  = 'selected="selected"';
    }else{
        $pending = 'selected="selected"';
        $payed  = '';
    }
$user_data = get_userdata( $post->user_id );

echo '<tr>
     <td>'.$post->user_id.'</td>
     <td>'.$user_data->user_nicename.'</td>
     <td>'.$post->request_date.'</td>
     <td>'.$post->user_balance.'</td>
      <input type="hidden" value="'.$post->user_balance.'" name="user_balance" />
     <td>'.$post->request_amount.'</a></td>
      <input type="hidden" value="'.$post->request_amount.'" name="request_amount" />
     <td>'.$post->user_paypal.'</td>
     <td>
     <select id="withdrawal_status" class="postform" name="withdrawal_status['.$post->id.']">
     <option class="level-0" value="0" '.$pending.'>Pending</option>
     <option class="level-0" value="1" '.$payed.'>Payed</option></td>
   </tr>';
$post_count++;
}
if($post_count == 0){
    echo '<tr>
<td>No transactions yet.</td>
</tr>';
}
?>
</tbody>
</table>
<div class="tablenav bottom">

		<div class="alignleft actions">
		</div>
		<div class="alignleft actions">
		</div>
<div class="tablenav-pages"><span class="displaying-num"><?php echo $rows_total_count;?> items</span>
<span class="pagination-links">
    <a href="<?php echo get_option('siteurl').'/wp-admin/admin.php?page='.THEME_NAME.'-withdrawals&transactions_page=1'?>" title="Go to the first page" class="first-page <?php if($page==1){echo "disabled";}?>">«</a>
    <a href="<?php echo get_option('siteurl').'/wp-admin/admin.php?page='.THEME_NAME.'-withdrawals&transactions_page='.($page-1);?>" title="Go to the previous page" class="prev-page <?php if($page==1){echo "disabled";}?>"><</a>

<span class="paging-input"><?php echo $page;?> of <span class="total-pages"><?php echo $total_pages;?></span></span>

<a href="<?php echo get_option('siteurl').'/wp-admin/admin.php?page='.THEME_NAME.'-withdrawals&withdrawals_page='.($page+1);?>" title="Go to the next page" class="next-page <?php if($page==$total_pages){echo "disabled";}?>">></a>
<a href="<?php echo get_option('siteurl').'/wp-admin/admin.php?page='.THEME_NAME.'-withdrawals&withdrawals_page='.$total_pages;?>" title="Go to the last page" class="last-page <?php if($page==$total_pages){echo "disabled";}?>">»</a></span></div>
		<br class="clear">
	</div>

<input type="submit" value="Save" name="withdrawals_submit" class="button"/>
</form>
</div>