var fso = new ActiveXObject("Scripting.FileSystemObject");
var dir = 'd:\\transact\\temp\\tmp_logs';
var rdir = 'd:\\transact\\wwwroot\\risk';
var dirs = fso.GetFolder(dir);
var files = new Enumerator(dirs.files);
files.moveFirst(); 
var wsh = WScript.CreateObject("Wscript.Shell");
var arg = WScript.CreateObject("WScript.Network");
pk = arg.ComputerName;

for (; !files.atEnd(); files.moveNext()) {
	
	if ( (files.item().Name.indexOf(".log") != -1) ) { //Если нашли, начинаем его читать.
	//WScript.echo("start if first");
	FileName = files.item().Name;
	//WScript.echo(FileName.indexOf("flag_"));
	//WScript.echo(FileName.indexOf(".flag"));
	//WScript.echo(FileName.slice(5,6));
	//ftype = FileName.slice(indexOf("flag_"), )
	//x = FileName.slice(5,6);
	//if (x == 'D') {
	wsh.Run("cmd /c d:\\transact\\batch\\winrar\\winrar.exe m -ep "+dir+"\\"+pk+".rar "+dir+"\\"+FileName+" >> "+rdir+"\\log.log", 0,true);
		//WScript.echo("cmd /c d:\\transact\\batch\\winrar\\winrar.exe m "+dir+"\\default.rar "+dir+"\\default.log >> "+dir+"\\log.log");
	//}
	/*if (x == 'W') {
		wsh.Run("cmd /c d:\\transact\\batch\\winrar\\winrar.exe m -ep "+dir+"\\"+pk+".rar "+dir+"\\wrapper.log >> "+dir+"\\log.log", 0,true);
		//WScript.echo("cmd /c d:\\transact\\batch\\winrar\\winrar.exe m "+dir+"\\default.rar "+dir+"\\wrapper.log >> "+dir+"\\log.log");
	}*/
	//wsh.Run("d:\\transact\\batch\\winrar\\winrar.exe m "+dir+"\\default.rar "+dir+"\\default.log >> "+dir+"\\log.log");
	
	}

}
/*
if (fso.FileExists(dir+)) {

}
*/