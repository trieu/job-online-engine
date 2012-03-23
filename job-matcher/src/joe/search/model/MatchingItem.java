package joe.search.model;

import java.io.Serializable;
import java.util.List;



public interface MatchingItem extends Serializable {
	public long getItemID();
	public List<MatchedItemInfo> getMatchedItemInfoList();
	public void setMatchedItemInfoList(List<MatchedItemInfo> newList);
}
