SELECT `BaseClassID`, `MatchedClassID`, LEFT(`MatchedStructure`, 256) 
FROM matched_class_structure AS m
WHERE m.BaseClassID = 1 AND m.MatchedClassID = 2

SELECT DISTINCT fields.FieldID, fields.FieldName
FROM fields
WHERE fields.FieldID IN ("19","41","22","44")