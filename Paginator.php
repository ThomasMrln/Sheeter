<?php


/**
 *	@resume	Paginator is a PHP class allowing to create quickly and simply pagination for your content
**/

class Paginator {
	
	private $name;
	private $nbElPerPage;
	private $nbElTotal;
	private $nbPages;
	private $current;
	
	private $style 			= 	1;
	private $lang 			= 	"en";
	private $nbExtremities 	= 	3;
	private $around 		= 	2;
	
	public function __construct($name='Paginator', $nbElTotal, $nbElPerPage=10) {
			$this->name			=	htmlspecialchars(trim($name));
			$this->nbElPerPage	=	intval($nbElPerPage);
			$this->nbElTotal	=	intval($nbElTotal);
			$this->nbPages		=	intval($this->nbElTotal/$this->nbElPerPage);
			//$this->current		=	this->get_current();
	}
	
	public function __get($key) 		{	return $this->$key; 	}
	public function __set($key, $value)	{	$this->$key	=	$value;	}
	
	public function __toString() {
			if (!isset($this->style))	$this->style	=	1;
			
			return generate($this->style);	
	}
	
	public function get_current() {
			// Parser URI
			// Garder le chiffre seul --> current
	}
	
	public function get_arounds() {
			$laround	=	0;
			$raround	=	0;
			if 	($this->current - $this->around <= 0)					$laround	=	abs($this->current - $this->around);
			if 	($this->current + $this->around > $this->nbElTotal)		$raround	=	abs( ($this->current + $this->around) - $this->nbElTotal );
			
			
	}
	
	public function get_extremities() {
			$extremities=	array();
			
			// Calcul extremities for the beginning of pagination
			$calcul	=	$this->current - $this->nbExtremities;
			
			if 		($calcul < $this->around)			$extremities['begin']	=	0;
			elseif 	($calcul >= $this->nbExtremities)	$extremities['begin']	=	$this->nbExtremities;
			elseif 	($calcul >= $this->around)			$extremities['begin']	=	abs($calcul);

			
			// Calcul for the end of pagination
			$calcul	=	$this->nbPages - ($this->current + $this->around);
			
			if 		($calcul <= 0)						$extremities['end']	=	0;
			elseif 	($calcul >= $this->nbExtremities)	$extremities['end']	=	$this->nbExtremities;
			else 										$extremities['end']	=	abs($calcul);
			
			return $extremities;
	}
	
	public function get_beginning() {
			$pages	=	array();

			if 		($current - $this->nbExtremities <= 0)						$this->nbExtremities	=	0;
			elseif	($current - $this->nbExtremities < $this->nbExtremities)	$this->nbExtremities	=	abs($this->current - $this->nbExtremities);
			
			for ($i=0; $i < $this->nbExtremities; $i++)
					$pages[]	=	1+$i;
					
			return $pages;
	}
	
	public function get_end() {
			$pages	=	array();
			$this->nbExtremities	=	($this->current-$this->nbExtremities < $this->nbExtremities)?	$this->current - $this->nbExtremities	:	$this->nbExtremities	;
			
			for ($i=0; $i < $this->nbExtremities; $i++)
					$pages[]	=	$nbElTotal-$i;
					
			return $pages;
	}
	
	public function generate() {
			$paginator	 =	'<!-- Paginator, quickly and simply php pagination by @ThomasMrln -->';
			$paginator	.=	'<div id="paginator-container">';
			switch($this->style) {
					case 1 :
							$extremities	=	$this->get_extremities();
							print_r($extremities);
							
							// Prev
							$numPage 	=	1;
							for ($i=$numPage; $i <= $extremities['begin']; $i++) {
									$paginator	.=	'<a title="'.$this->name.' - page '.$i.'" href="'.Rope::current_url().$i.'/" 
															class="'.(($i == $this->current)?'current-paginator':'normal-paginator').'">'.$i.'</a>';
							}

							// Middle
							$numPage	=	$this->current - $this->around;
							if 	($i != $numPage)	$paginator	.=	'<span clas="separator-paginator">...</span>';
							for ($i= $numPage; $i <= $this->current+$this->around; $i++) {
									$paginator	.=	'<a title="'.$this->name.' - page '.$i.'" href="'.Rope::current_url().$i.'/" 
															class="'.(($i == $this->current)?'current-paginator':'normal-paginator').'">'.$i.'</a>';
							}
							
							// Next
							$numPage	=	$this->nbPages - $extremities['end'];
							if 	($i != $numPage)	$paginator	.=	'<span clas="separator-paginator">...</span>';
							for ($i=$numPage+1; $i <= $this->nbPages; $i++) {
									$paginator	.=	'<a title="'.$this->name.' - page '.$i.'" href="'.Rope::current_url().$i.'/" 
															class="'.(($i == $this->current)?'current-paginator':'normal-paginator').'">'.$i.'</a>';
							}
							break;
							
					case 2 : 
							break;
							
					case 3 :
							break;
							
					default :
							trigger_error("This style doesn't exists for Paginator. Please change your settings.");
							return false;
							break;
			}
			$paginator	.=	'</div>';
			return $paginator;
	}
	
}