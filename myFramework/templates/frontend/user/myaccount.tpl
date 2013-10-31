<form action ="{SITE_URL}/user/account" method="post">

<table>
	<tr>
		<td>Username:</td>
		<td>{USERNAME}</td>
	</tr>

	<tr>
		<td>Email:</td>
		<td>{EMAIL}</td>
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
 <input type="submit" value="Update data">
</form>