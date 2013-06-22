<?php

namespace Squeeze\App;

// Create a field
// We'll create a new instance of the field object.
// Set a couple variables
// `setFieldType` accepts numerous different values. Check the class for the allowed types.
$textarea = new Core\SettingsField;
$textarea->setFieldKey('SQ_textarea');
$textarea->setFieldTitle('Values List');
$textarea->setFieldType(Core\SettingsField::FIELD_TEXTAREA);
$textarea->setFieldInstructions('Enter One Value Per Line');

// The stored value can be parsed prior to display.
$textarea->setFieldPreParse(function($value) {
  // We're assigning this callback to the settings field object.
  // It takes the value of the field as a parameter.
  // You can manipulate the data in any way you like.
  // Just make sure to return the result at the end.

  // In this case, we're storing our data as a json-encoded array
  // because json is better than serialization dammit.
  // We'll convert the json to an array, convert that to a string
  // and put one value on each line.
  $sections = json_decode($value);
  return (is_array($sections)) ? implode("\n", $sections) : $sections;
});

// We can also define a function to parse the value before saving.
$textarea->setFieldPostParse(function($value) {
  // This callback is going to run when the value is saved to the database.
  // Generally speaking it'll do the opposite of what the `setFieldPreParse` callback did.
  // So in this case, we're splitting our string into an array at the newline character
  // Encoding it as json, and returning that as the parsed value.
  $sections = explode("\n", $value);
  foreach($sections as $key=>$val) {
    $sections[$key] = trim($val);
  }
  return json_encode($sections);
});


// Create a settings section.
// Make sure you've got your fields created before you create your group.
// The `setFields` function will take either a single field or an array of field objects.
$section = new Core\SettingsSection;
$section->setGroupTitle('Custom Field Group');
$section->setGroupKey('SQ_group');
$section->setGroupPage('SQ_sub_menu');
$section->setFields(array(
  $textarea
));
$section->execute();