SELECT r.*
FROM ((SELECT objects.ObjectID, FIELDS.FieldID, FIELDS.FieldName, fieldoptions.OptionName AS FieldValue
FROM objects
INNER JOIN fieldvalues ON fieldvalues.ObjectID = objects.ObjectID
INNER JOIN FIELDS ON (FIELDS.FieldID = fieldvalues.FieldID AND FIELDS.FieldTypeID >= 4 AND FIELDS.FieldTypeID < 7 AND FIELDS.ValidationRules LIKE '%searchable%' AND FIELDS.FieldID IN (
SELECT field_form.FieldID
FROM field_form, form_process, class_using_process
WHERE field_form.FormID = form_process.FormID AND form_process.ProcessID = class_using_process.ProcessID AND class_using_process.ProcessOrder = 0 AND class_using_process.ObjectClassID = '1'))
INNER JOIN fieldoptions ON fieldoptions.FieldOptionID = fieldvalues.FieldValue
WHERE objects.ObjectClassID = '1') UNION (
SELECT objects.ObjectID, FIELDS.FieldID, FIELDS.FieldName, fieldvalues.FieldValue AS FieldValue
FROM objects
INNER JOIN fieldvalues ON fieldvalues.ObjectID = objects.ObjectID
INNER JOIN FIELDS ON (FIELDS.FieldID = fieldvalues.FieldID AND FIELDS.FieldTypeID >= 1 AND FIELDS.FieldTypeID <= 3 AND FIELDS.ValidationRules LIKE '%searchable%' AND FIELDS.FieldID IN (
SELECT field_form.FieldID
FROM field_form, form_process, class_using_process
WHERE field_form.FormID = form_process.FormID AND form_process.ProcessID = class_using_process.ProcessID AND class_using_process.ProcessOrder = 0 AND class_using_process.ObjectClassID = '1'))
WHERE objects.ObjectClassID = '1')) r
WHERE r.ObjectID IN (
	112,111,109
)
SELECT DISTINCT ObjectID
	FROM (
	SELECT ObjectID
	FROM fieldvalues
	WHERE (FieldID = 102 AND FieldValue LIKE '%2009%') 
	UNION
	SELECT ObjectID
	FROM fieldvalues
	WHERE (FieldID = 109 AND FieldValue = 461)
	) rs


