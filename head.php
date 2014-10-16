<?php

$head = <<<_END
<head>
	<link rel="stylesheet" type="text/css" href="http://engr.oregonstate.edu/~rymalc/style.css";></link>
	<title>{$title}</title>
	<script type="text/x-mathjax-config">
		MathJax.Hub.Config ({
			tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]},
			menuSettings: {zoom: "Click"}
		});
	</script>
	<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
	<script type="text/javascript" src="../js/funcs.js"></script>
</head>
_END;
?>
