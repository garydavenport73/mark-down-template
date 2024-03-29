<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markdown Editor</title>
    <style>
    #markdown{width:80%;min-width:425px;max-width:600px;height:100px}
    footer {
    position: fixed;
    bottom: 0;
    left: 50%;
    text-align: center;
    transform: translate(-50%, 0%);
}
    </style>
</head>
<body>
	<h1>Live Markdown Editor</h1>
	<h2>Your Markdown Here:</h2>
	<textarea id="markdown" oninput="updateResult();">
## Supported features

* Headers `#` 
* Blockquotes `>`
* Ordered lists `1`
* Unordered lists `*`
* Paragraphs
* Links `[]()`
* Images `![]()`
* Inline `<em>` emphasis `*`
* Inline `<strong>` emphasis `**`

## Unsupported features

* References and IDs
* Escaping of Markdown characters
* Nesting

## To use in Geany IDE:

This is a simple workaround if the Geany Markdown Plugin does not work for you:

1 Copy this file "`markdownTemplate.html`" to `/home/username/.config/geany/templates/files` (*see Note)
2 When needed go to File->New (with Template)
3 Press F5 to launch file.
4 When satisfied with your markdown file, save or copy to clipboard.

`*` Note: Please inspect your file structure if using Windows.  The location may be located at: `C:\users\UserName\Roaming\geany\templates\files`

## License

mmd - MIT Copyright (c) 2012 Mathieu 'p01' Henri

[GitHub site](https://github.com/p01/mmd.js)

markdowntemplate.html - Copyright(c) 2022 by Gary 'garydavenport73' Davenport

[GitHub site](https://github.com/garydavenport73/mark-down-template)
</textarea>
	<div>
		<button onclick="saveStringToTextFile(document.getElementById('markdown').value,'README','.md')">SAVE MARKDOWN TO FILE</button>
		<button onclick="copyStringToClipboard(document.getElementById('markdown').value)">COPY MARKDOWN TO CLIPBOARD</button>
	</div>
    <h2>Your results below:</h2>
	<hr>
    <div id="result">Your converted html</div>
 <footer id="visit-counter"></footer>
<script>
	function updateResult(){
		let markdownString = document.getElementById('markdown').value;
		console.log(markdownString);
		let resultDiv = document.getElementById('result');
		resultDiv.innerHTML=mmd(markdownString);
	}
	
	function mmd(src){
		var h='';
		function escape(t)
		{
			return new Option(t).innerHTML;
		}
		function inlineEscape(s)
		{
			return escape(s)
				.replace(/!\[([^\]]*)]\(([^(]+)\)/g, '<img alt="$1" src="$2">')
				.replace(/\[([^\]]+)]\(([^(]+?)\)/g, '$1'.link('$2'))
				.replace(/`([^`]+)`/g, '<code>$1</code>')
				.replace(/(\*\*|__)(?=\S)([^\r]*?\S[*_]*)\1/g, '<strong>$2</strong>')
				.replace(/(\*|_)(?=\S)([^\r]*?\S)\1/g, '<em>$2</em>');
		}
		src
		.replace(/^\s+|\r|\s+$/g, '')
		.replace(/\t/g, '    ')
		.split(/\n\n+/)
		.forEach(function(b, f, R)
		{
			f=b[0];
			R=
			{
				'*':[/\n\* /,'<ul><li>','</li></ul>'],
				'1':[/\n[1-9]\d*\.? /,'<ol><li>','</li></ol>'],
				' ':[/\n    /,'<pre><code>','</code></pre>','\n'],
				'>':[/\n> /,'<blockquote>','</blockquote>','\n']
			}[f];
			h+=
				R?R[1]+('\n'+b)
					.split(R[0])
					.slice(1)
					.map(R[3]?escape:inlineEscape)
					.join(R[3]||'</li>\n<li>')+R[2]:
				f=='#'?'<h'+(f=b.indexOf(' '))+'>'+inlineEscape(b.slice(f+1))+'</h'+f+'>':
				f=='<'?b:
				'<p>'+inlineEscape(b)+'</p>';
		});
		return h;
	};
	
	function saveStringToTextFile(str1, basename = "myfile", fileType = ".txt") {
		let filename = basename + fileType;
		let blobVersionOfText = new Blob([str1], {
			type: "text/plain"
		});
		let urlToBlob = window.URL.createObjectURL(blobVersionOfText);
		let downloadLink = document.createElement("a");
		downloadLink.style.display = "none";
		downloadLink.download = filename;
		downloadLink.href = urlToBlob;
		document.body.appendChild(downloadLink);
		downloadLink.click();
		downloadLink.parentElement.removeChild(downloadLink);
	}

	function copyStringToClipboard(str) {
		//https://techoverflow.net/2018/03/30/copying-strings-to-the-clipboard-using-pure-javascript/
		let el = document.createElement('textarea');
		el.value = str;
		el.setAttribute('readonly', '');
		el.style = {
			position: 'absolute',
			left: '-9999px'
		};
		document.body.appendChild(el);
		el.select();
		document.execCommand('copy');
		document.body.removeChild(el);
		alert('Copied to Clipboard.');
	}

updateResult();
	
</script>
    <?php
///////////////Page counter/////////////////////    
$pageName=basename(__FILE__,".php");
$countFileName=$pageName."-count.txt";
$int=0;
$contents=file_get_contents($countFileName);
$int = (int)$contents;
$int=$int+1;
file_put_contents($countFileName,(string)($int));
//require_once($pageName.".html");
echo ("<script>document.getElementById('visit-counter').innerHTML='".$int." visits.'</script>");
////////////////////////////////////////////////
?>

</body>
</html>


