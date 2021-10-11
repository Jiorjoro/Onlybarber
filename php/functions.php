<?php
	
	function qBoa($valor) {
		$valor = trim($valor);
		$valor = filter_var($valor, FILTER_SANITIZE_STRING);
		return $valor;
	}

	function numerin($n) {
		if($n >= 1000){
			if($n >= 1000000){
				if($n >= 1000000000){
					$len = strlen($n) - 9;
					$n = substr($n, -0, $len) . 'B';
					goto finale;
				}
				$len = strlen($n) - 6;
				$n = substr($n, -0, $len) . 'M';
				goto finale;
			}
			$len = strlen($n) - 3;
			$n = substr($n, -0, $len) . 'K';
			goto finale;
		}

		finale:
		return $n;
	}
	
?>