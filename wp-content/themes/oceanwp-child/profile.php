<?php /* Template Name: profile */ 

get_header(); 

global $current_user;

		 $var=get_currentuserinfo();
		 $email= $var->user_email ;
		 $password= $var->user_pass ;
		 $name=  $var->user_nicename ;
		 $id=$var->ID;
		 $Phonenumber= get_user_meta($id) ; 
		 $number=$Phonenumber['billing_phone'][0]; 

if(isset($_REQUEST["Update"]))
{
		$user_id = $id;
		$email=$_REQUEST["email"];
		$password=$_REQUEST["password"];
		$name=$_REQUEST["name"];
		$Phonenumber=$_REQUEST["Phonenumber"];
		$user_id = wp_update_user(array('ID' => $user_id));
		$user_id;
		update_user_meta($user_id, 'billing_phone', $number);
		update_user_meta($user->ID, $billing_phone, $number);

		
if($user_id)
{
	echo "data enter successfully";
}
else
{
	echo "error";
}
}
?>

<form action="" method="post">
<input type="text" name="email" value="<?php echo $email;?>" placeholder="email">
<input type="password" name="password" value="<?php echo $password;?>" placeholder="password">
<input type="text" name="name" value="<?php echo $name;?>" placeholder="name"><br>
<input type="text" name="Phonenumber" value="<?php echo $number;?>" placeholder="Phonenumber">
<h3>Wachtwoord vergeten?</h3>
<input type="submit" name="Update" value="Update">
</form>

<?php get_footer(); ?>