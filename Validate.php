<?php

class Validate extends Model
{
	private $_passed = false,
			$_errors = array(),
			$_db = null;


	

	public function check($source, $items = array())
	{
		foreach($items as $item => $rules)
		{
			foreach($rules as $rule => $rule_value)
			{
				//echo "{$item} {$rule} must be {$rule_value} </br>";
				//trim prevents white space
				$value = trim($source["$item"]);
				$item = escape($item);

				if($rule === 'required' && $value == "")
				{
					$item = str_replace('_', ' ', $item);
					$this->addError("$item is required");
				}
				else if(!empty($value))
				{
					switch($rule)
					{
						case 'min':
							if(strlen($value) < $rule_value)
							{
								$this->addError("{$item} must be a minimun of {$rule_value} characters");
							}
						break;

						case 'max':
							if(strlen($value) > $rule_value)
							{
								$this->addError("{$item} must be a maximums of {$rule_value} characters");
							}
						break;

						case 'matches':
							if($value != $rule_value)
							{
								// echo "</br>";
								// echo "</br>";
								// echo "</br>";
								// echo "hello";
								// echo "</br>";
								// echo $value;
								// echo "</br>";
								// echo $rule_value;
								// echo "</br>";
								// echo "</br>";
								// echo "</br>";
								$item = str_replace('_', ' ', $item);
								$this->addError("{$item} must match new password");
							}
						break;

						case 'unique':
						
						$query_string = "SELECT id FROM {$rule_value} WHERE {$item} = '{$value}'";
						$exexition = $this->db->select($query_string);

						
						
						// echo $hashCheck->rowCount();
						if(count($exexition) > 0)
						{
							$this->addError("{$item} <b>$value</b> Already exists, try another {$item}");
						}
						break;
					}
				}
			}
		}

		if(empty($this->_errors))
		{
			$this->_passed = true;
		}
		return $this;
	}

	public function addError($error)
	{
		$this->_errors[] = $error;
	}

	public function errors()
	{
		return $this->_errors;
	}

	public function passed()
	{
		return $this->_passed;
	}
}