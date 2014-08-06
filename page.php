<?php

echo <<<_END
<html>
	{$head}
	<body onload="loadxml('test.xml');load('html/index.html','cont');">
		<div class="left">
			{$side}
		</div>
		<div class= "center">
			{$main}	
		</div>
	</body>
</html>
_END;

?>
