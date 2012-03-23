package joe.search.model;

import joe.search.base.SimpleLog;



public class MatchedItemInfo implements Comparable<MatchedItemInfo> {
	private static final SimpleLog log = new SimpleLog(MatchedItemInfo.class);
	private long matchedItemID;
	private float weight;
	
	public MatchedItemInfo(){}
	public MatchedItemInfo(long matchedItemID, float weight) {
		this.matchedItemID = matchedItemID;
		this.weight = weight;
	}
	
	public long getMatchedItemID() {
		return matchedItemID;
	}
	
	public void setMatchedItemID(long matchedItemID) {
		this.matchedItemID = matchedItemID;
	}
	
	public float getWeight() {
		return weight;
	}
	
	public void setWeight(float weight) {
		this.weight = weight;
	}
	
	/**
	 * Sort assendent
	 */
	public int compareTo(MatchedItemInfo matchedItem) {
		if(this.weight > matchedItem.getWeight()) {
			return -1;
		}
		else if (this.weight < matchedItem.getWeight()) {
			return 1;
		}
		return 0;
	}
	

	@Override
	public int hashCode() {
		final int prime = 31;
		int result = 1;
		result = prime * result	+ (int) (matchedItemID ^ (matchedItemID >>> 32));
		return result;
	}
	@Override
	public boolean equals(Object obj) {
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		final MatchedItemInfo other = (MatchedItemInfo) obj;
		if (matchedItemID != other.matchedItemID)
			return false;
		return true;
	}
	
}
