<?php
class Dictionary extends Model {
	protected $id;
	protected $term;
	protected $definition;
	
	public function __construct() {
		$this->id = new IntegerField;
		$this->term = new StringField;
		$this->definition = new TextField;
		$this->setPKField("id");
	}
}
?>