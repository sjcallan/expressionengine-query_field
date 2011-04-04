DESCRIPTION:
This simple ExpressionEngine fieldtype allows you to develop dropdown or multiselect menus based off of custom SQL queries.  Simply define your field text, value and your sql statement.  Make sure that your field text field and field value field is contained in your SELECT.

-------------------------------

EX:
Value Field: cat_id
Visible Text Field: cat_name
SQL Query: SELECT cat_id, cat_name FROM exp_categories WHERE site_id=1 ORDER BY cat_name ASC
Form Type: Dropdown

This will create a select field with all of your categories.

-------------------------------

INSTALLATION:
Upload the query_field folder to your /systen/expressionengine/third_party/ directory 
Log into EE-> Add-Ons --> FieldTypes --> Install Query Field
You're good to go

