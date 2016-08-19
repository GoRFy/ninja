

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<body style="margin: 0; padding: 0; font-family: sans-serif, Tahoma;">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
		<tr>
			<td align="center" style="padding: 40px 0 30px 0; border-bottom: 2px solid #6C6599;">
				<span style="color: #6C6599;font-size:26px"> Sport Nation </span>
			</td>
		</tr>
		<tr>
			<td bgcolor="#fff" style="padding: 30px 0 30px 0;color:black">
				<p style="font-size:22px ; margin-bottom: 20px;">Une dernière étape...</p>
				<p style="font-size:18px ;">Bravo <b><?= $_SESSION['username']; ?></b>, votre compte a été crée ! </p>
				<p style="font-size:18px ; margin-bottom: 40px;">Afin de pouvoir vous connecter vous devez valider votre compte, veuillez cliquer sur le lien ci-dessous</p>
			</td>
		</tr>
		<tr>
			<td align="center" style="padding: 10px 0 30px 0;" >
				<a style="padding: 15px; border: 1px solid #555; background-color: #6C6599; border-radius: 10px; color: #fff; text-decoration: none; font-weight: 600" href="<?= User::getEmailLink("subscribe"); ?>">
					Activer mon compte
				</a>
			</td>
		</tr>
	</table>
</body>
</html>
