package joe.search.base;

import java.io.File;
import java.io.IOException;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import org.apache.lucene.document.Document;
import org.apache.lucene.document.Field;
import org.apache.lucene.store.Directory;
import org.apache.lucene.store.FSDirectory;

public abstract class IndexEngine {

    // TODO: is enough ??
    public static final String[] ID_ATTRIBUTES = new String[]{"isbn", "ubc", "ean"};
    public static final String ITEM_OWNER = "%Owner";
    public static final String ITEM_NAME = "%Name";
    public static final String ITEM_ATTRIBUTES = "%Attributes";
    public static final String ITEM_ID_ATTRIBUTE = "%ID-Attribute";
    public static final String ITEM_DESCRIPTION = "%Description";
    public static final String ITEM_TAGS = "%Tags";
    public static final String ITEM_ID = "%ID";
    public static final String ITEM_TYPE = "%Type";
    public static final String ITEM_TRADE_ENABLED = "%trade-enabled";
    public static final String ITEM_SELL_ENABLED = "%sell-enabled";
    public static final String ITEM_RENT_ENABLED = "%rent-enabled";
    public static final String ITEM_SELL_PRICE = "%sell-price";
    public static final String ITEM_RENT_PRICE = "%rent-price";
    public static final String ITEM_MIN_PRICE = "%min-price";
    public static final String ITEM_MAX_PRICE = "%max-price";
    private static String indexDirectoryPath;
    private static Directory indexDirectory;

    public IndexEngine() {
        getIndexDirectoryPath();
    }

    public static String getIndexDirectoryPath() {
        if (indexDirectoryPath == null) {
            StringBuilder sBuilder = new StringBuilder();
            //sBuilder.append(JiveGlobals.getJiveHome()); //FIXME
            sBuilder.append(File.separator);
            sBuilder.append("search");
            sBuilder.append(File.separator);
            sBuilder.append("yopco-item");
            indexDirectoryPath = sBuilder.toString();
        }
        return indexDirectoryPath;
    }

    public static String getUserIndexDirectoryPath(String username) {
        StringBuilder sBuilder = new StringBuilder();
        //sBuilder.append(JiveGlobals.getJiveHome());//FIXME
        sBuilder.append(File.separator);
        sBuilder.append("search");
        sBuilder.append(File.separator);
        sBuilder.append(username);
        return sBuilder.toString();
    }

    public static Directory getIndexDirectory() {
        if (indexDirectory == null) {
            try {
                indexDirectory = FSDirectory.open(new File(getIndexDirectoryPath()));
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
        return indexDirectory;
    }

    public static Directory getUserIndexDirectory(String username) throws IOException {
        return FSDirectory.open(new File(getUserIndexDirectoryPath(username)));
    }

    public static void addField(Document document, String fieldName, String value,
            Field.Store filedStore, Field.Index fieldIndex, Field.TermVector fieldTermVector) {
        Field field = new Field(fieldName, getNotNullValue(value), filedStore, fieldIndex,
                fieldTermVector);
        document.add(field);
    }

    /**
     * Add field to document without using Normalization
     *
     * @param document
     * @param fieldName
     * @param value
     * @param filedStore
     */
    public static void addNoNormField(Document document, String fieldName, Number value,
            Field.Store filedStore) {
        Field field = new Field(fieldName, getNotNullValue(value), filedStore, Field.Index.NOT_ANALYZED_NO_NORMS);
        document.add(field);
    }

    /**
     * Add field to document without using Normalization
     *
     * @param document
     * @param fieldName
     * @param value
     * @param filedStore
     */
    public static void addNoNormField(Document document, String fieldName, String value,
            Field.Store filedStore) {
        Field field = new Field(fieldName, value, filedStore, Field.Index.NOT_ANALYZED_NO_NORMS);
        document.add(field);
    }

    public static String getNotNullValue(Object s) {
        if (s != null) {
            return s.toString();
        }
        return "";
    }

    public static String fieldValue(Object s) {
        if (s != null) {
            return s.toString();
        }
        return "";
    }

    /**
     *
     * Call when build index for all item Use Locally by subclass
     *
     * @return
     */
    protected List<Long> getAllItemIDs() {
        String sql = "SELECT itemID FROM yopcoItem";
       //TODO
        return null;
    }

    /**
     *
     * Call when build index for all item Use Locally by subclass
     *
     * @return
     */
    protected static String getAllCollectionsOfItem(long itemID) {
        String sql = "SELECT name FROM yopcoCollection, yopcoItemCollection WHERE yopcoCollection.collectionID = yopcoItemCollection.collectionID AND yopcoItemCollection.itemID = ?";
        Connection con = null;
        PreparedStatement pstmt = null;
        StringBuilder sBuilder = new StringBuilder();
        //TODO
        return sBuilder.toString().trim();
    }
}
