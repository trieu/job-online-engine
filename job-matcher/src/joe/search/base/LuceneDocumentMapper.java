package joe.search.base;

import java.util.Map;
import java.util.Set;

import joe.search.model.ExternalItem;
import org.apache.lucene.document.Document;
import org.apache.lucene.document.Field;


import joe.search.model.Item;

public class LuceneDocumentMapper extends IndexEngine{

	/**
	 * The details, mapping indexed field of Item to Lucene Document
	 *
	 * @param dbItem
	 * @return
	 */
	public static Document ItemToDocument(Item dbItem) {
		Document doc = new Document();

		return doc;
	}







	/**
	 * The details, mapping indexed field of Item to Lucene Document
	 *
	 * @param exItem
	 * @return
	 */
	public static Document ExternalItemToDocument(ExternalItem exItem) {
		Document doc = new Document();
		
		return doc;
	}


	public static String[] normalizeAttributesOfItem(Map<String, String> attrs){
		String [] attributes = new String[2];
		Set<String> keys = attrs.keySet();
		String value;

		StringBuilder stringBuilder = new StringBuilder();
		StringBuilder identity_field = new StringBuilder();
		for (String key : keys) {
			if (!key.contains("%")) {
				for (String id_atrr : IndexEngine.ID_ATTRIBUTES) {
					if(key.toLowerCase().contains(id_atrr)){
						identity_field.append(attrs.get(key)).append(" ");
					}
				}
				//value = attrs.get(key).replace(" ", "_");//normalize data
				value = attrs.get(key);
				stringBuilder.append(value).append(" ");
			}
		}
		attributes[0] = stringBuilder.toString().trim();
		String tem = identity_field.toString().trim();
		attributes[1] = (tem.length()>0) ? tem : null;
		return attributes;
	}
}
