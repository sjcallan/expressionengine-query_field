<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query_field_ft extends EE_Fieldtype {

	var $info = array(
		'name'		=> 'Query Field',
		'version'	=> '1.0'
	);
	
	var $has_array_data = TRUE;
	
	function __construct()
	{
		parent::EE_Fieldtype();
		$this->EE->load->helper("custom_field_helper");
		$this->EE =& get_instance();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Display Field on Publish
	 *
	 * @access	public
	 * @param	existing data
	 * @return	field html
	 *
	 */
	function display_field($data)
	{
		
		$values = decode_multi_field($data);
		$query_sql		= $this->settings["query_sql"];
		$query_id		= $this->settings["query_id"];
		$query_label	= $this->settings["query_label"];
		$form_type		= $this->settings["query_form_type"];
		
		$options = Array();
		$options[""] = "- Select One -";
		
		$query = $this->db->query($query_sql);
		
		if($query->num_rows() > 0)
		{
			
			foreach($query->result() AS $record)
			{
				$options[$record->$query_id] = $record->$query_label;
			}
			
		}
		
		if($form_type == "multiselect")
		{
			return form_multiselect($this->field_name.'[]', $options, $values, 'id="'.$this->field_name . '" size="20"');
		}
		else
		{
			return form_dropdown($this->field_name, $options, $values, 'id="'.$this->field_name . '"');
		}
	
	}
	
	function save($data)
	{
		if(is_array($data))
		{
	
			$output = "";
			
			if($data != "")
			{
				foreach($data AS $id)
				{
					$output = $output . $id . "|";
				}
			}
			
			if(strlen($output) > 0)
			{
				$output = substr($output, 0, strlen($output)-1);
			}
		
		}
		else
		{
			$output = $data;
		}
		
		return $output;
	
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Save Global Settings
	 *
	 * @access	public
	 * @return	global settings
	 *
	 */
	function save_global_settings()
	{
		return array_merge($this->settings, $_POST);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Display Settings Screen
	 *
	 * @access	public
	 * @return	default global settings
	 *
	 */
	function display_settings($data)
	{
		$query_sql			= isset($data['query_sql']) ? $data['query_sql'] : $this->settings['query_sql'];
		$query_id			= isset($data['query_id']) ? $data['query_id'] : $this->settings['query_id'];
		$query_label		= isset($data['query_label']) ? $data['query_label'] : $this->settings['query_label'];
		$query_form_type	= isset($data['query_form_type']) ? $data['query_form_type'] : $this->settings['query_form_type'];
			
		/* Form type */
			
			$form_type_options = array(
				"multiselect" => "Multiselect",
				"dropdown" => "Dropdown"
			);
		
			$this->EE->table->add_row(
				lang('Form Type','query_form_type'),
				form_dropdown('query_form_type',$form_type_options,$digital_asset_formtype)
			);
		
	}
	
	// --------------------------------------------------------------------

	/**
	 * Save Settings
	 *
	 * @access	public
	 * @return	field settings
	 *
	 */
	function save_settings($data)
	{
		return array(
			'query_id'	=> $this->EE->input->post('query_id'),
			'query_label'	=> $this->EE->input->post('query_label'),
			'query_sql'	=> $this->EE->input->post('query_sql'),
			'query_form_type'	=> $this->EE->input->post('query_form_type')
		);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Install Fieldtype
	 *
	 * @access	public
	 * @return	default global settings
	 *
	 */
	function install()
	{
		return array(
			'query_sql'	=> '',
			'query_id' => '',
			'query_label' => '',
			'query_form_type' => ''
		);
	}
	
	
}
// END Query_field_ft class

/* End of file ft.query_field.php */
