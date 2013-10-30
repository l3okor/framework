<form action = "{SITE_URL}/user/register" method="post">
<table>
	<tr>
		<td>Username:</td>
		<td><input type = "text" name= "username" value = "{USERNAME}"> </td>
	</tr>

	<tr>
		<td>Password:</td>
		<td><input type = "password" name= "password"></td>
	</tr>
	<tr>
		<td>Confirm Password:</td>
		<td><input type = "password" name="confirmpassword"></td>
	</tr>

	<tr>
		<td>Email:</td>
		<td><input type = "text" name="email" value = "{EMAIL}"></td>
	</tr>

	<tr>
		<td>Name:</td>
		<td><input type = "text" name="firstName" value="{NAME}"></td>
	</tr>

	<tr>
		<td>Surname:</td>
		<td><input type = "text" name="lastName" value="{SURNAME}"></td></tr>
	</tr>

</table>
	<input type="submit" value="Register!">

</form>