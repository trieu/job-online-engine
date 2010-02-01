package joe.search.base;

import joe.search.model.ExternalItem;
import java.util.List;
import joe.search.model.Item;
import joe.search.model.MatchingItem;



public interface IndexEngineManager {
	public void addItemToIndex(long itemID);
	public void removeItemFromIndex(long itemID);
	public void updateItemToIndex(long itemID);

	// startup index engine
	public void buildItemIndex();
	public void buildExternalItemIndexMatching(String username, List<ExternalItem> externalItems);

	// matching engine execute
	public MatchingItem searchMatchingItem(Item item);

}
