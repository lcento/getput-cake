<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
<html>
<head>
<title>Il Mattino</title>
<style type="text/css">
.tab {
	font-family: verdana;
	font-size: 11px;
}
.title {
	font-family: verdana;
	font-size: 12px;
	font-weight: bold;
}
.footer {
	font-family: verdana;
	font-size: 9px;
	font-style: italic;
}
hr {
	border: solid 1px #003366;
}
</style>
</head>

<body bgcolor="#EEEEEF">
<table width="500" border="0" align="center" class="tab">
	<tr>
		<td colspan="2" align="center" valign="top" class="title"><xsl:value-of select="Gerenza/Titolo"/> - Fondato nel <xsl:value-of select="Gerenza/Titolo/@Fondato"/></td>
	</tr>
	<tr>
		<td colspan="2" valign="top" class="footer"><hr/></td>
	</tr>
	<tr>
		<td width="50%" valign="top"><b> - Direttore Responsabile:</b></td>
		<td width="50%" valign="top"><xsl:value-of select="Gerenza/DirettoreResponsabile"/><br/><br/></td>
	</tr>
	<tr>
		<td width="50%" valign="top"><b> - Vice Direttore:</b></td>
		<td width="50%" valign="top"><xsl:value-of select="Gerenza/Vicedirettore"/><br/><br/></td>
	</tr>
	<tr>
		<td width="50%" valign="top"><b> - Uff. Red. Capo Centrale:</b></td>
		<td width="50%" valign="top">
			<xsl:for-each select="Gerenza/UffRedCapoCentrale/Item">
				<xsl:value-of select="."/><br/>
			</xsl:for-each><br/>
		</td>
	</tr>
	<tr>
		<td width="50%" valign="top"><b> - Presidente Ammin. Delegato:</b></td>
		<td width="50%" valign="top"><xsl:value-of select="Gerenza/PresidAmmDelegato"/><br/><br/></td>
	</tr>
	<tr>
		<td width="50%" valign="top"><b> - Consiglieri:</b></td>
		<td width="50%" valign="top">
			<xsl:for-each select="Gerenza/Consiglieri/Item">
				<xsl:value-of select="."/><br/>
			</xsl:for-each><br/>
		</td>
	</tr>
	<tr>
		<td width="50%" valign="top"><b> - Editrice:</b></td>
		<td width="50%" valign="top">
			<xsl:value-of select="Gerenza/Editrice/Nome"/><br/>
			<xsl:value-of select="Gerenza/Editrice/SedeLegale"/><br/><br/>
		</td>
	</tr>
	<tr>
		<td width="50%" valign="top"><b> - Redazione:</b></td>
		<td width="50%" valign="top">
			<xsl:value-of select="Gerenza/Editrice/Redazione"/><br/>
			Tel. <xsl:value-of select="Gerenza/Editrice/Redazione/@Telefono"/><br/><br/>
		</td>
	</tr>
	<tr>
		<td width="50%" valign="top"><b> - Amministrazione:</b></td>
		<td width="50%" valign="top">
			<xsl:value-of select="Gerenza/Editrice/Amministrazione"/><br/>
			Tel. <xsl:value-of select="Gerenza/Editrice/Amministrazione/@Telefono"/><br/><br/>
		</td>
	</tr>
	<tr>
		<td width="50%" valign="top"><b> - Prestampa:</b></td>
		<td width="50%" valign="top">
			<xsl:value-of select="Gerenza/Editrice/Prestampa"/><br/>
			Tel. <xsl:value-of select="Gerenza/Editrice/Prestampa/@Telefono"/><br/><br/>
		</td>
	</tr>
	<tr>
		<td width="50%" valign="top"><b> - Centro stampa Napoli:</b></td>
		<td width="50%" valign="top">
			<xsl:value-of select="Gerenza/CentroStampaNapoli/Nome"/><br/>
			<xsl:value-of select="Gerenza/CentroStampaNapoli/Indirizzo"/><br/><br/>
		</td>
	</tr>
	<tr>
		<td width="50%" valign="top"><b> - Concessionaria Pubblicità:</b></td>
		<td width="50%" valign="top">
			<xsl:value-of select="Gerenza/ConcessionariaPubblicita/Nome"/><br/>
			<xsl:value-of select="Gerenza/ConcessionariaPubblicita/Indirizzo"/><br/>
			Tel. <xsl:value-of select="Gerenza/ConcessionariaPubblicita/Telefono"/><br/>
			Fax. <xsl:value-of select="Gerenza/ConcessionariaPubblicita/Fax"/><br/><br/>
		</td>
	</tr>
	<tr>
		<td height="40" width="50%" valign="top"><b> - Copie arretrate:</b></td>
		<td height="40" width="50%" valign="top">
			Tel. <xsl:value-of select="Gerenza/CopieArretrate/Telefono"/><br/>
			Fax. <xsl:value-of select="Gerenza/CopieArretrate/Fax"/><br/>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center" valign="top" class="footer"><xsl:value-of select="Gerenza/Nota"/></td>
	</tr>
	<tr>
		<td colspan="2" valign="top" class="footer"><hr/></td>
	</tr>
</table>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
