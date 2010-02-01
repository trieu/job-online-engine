package joe.search.base;

import java.util.logging.Level;
import java.util.logging.Logger;
import joe.search.model.ExternalItem;
import java.io.File;
import java.io.IOException;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;


import joe.search.model.Item;
import joe.search.model.MatchingItem;
import org.apache.lucene.analysis.standard.StandardAnalyzer;
import org.apache.lucene.document.Document;
import org.apache.lucene.index.CorruptIndexException;
import org.apache.lucene.index.IndexReader;
import org.apache.lucene.index.IndexWriter;
import org.apache.lucene.index.StaleReaderException;
import org.apache.lucene.index.Term;
import org.apache.lucene.store.Directory;
import org.apache.lucene.store.FSDirectory;
import org.apache.lucene.store.LockObtainFailedException;
import org.apache.lucene.util.Version;

/**
 * Implemetation of IndexEngine
 *
 */
public class IndexEngineManagerImpl extends IndexEngine implements IndexEngineManager {
    SimpleLog log = new SimpleLog(this.getClass());

    // using executor queue to store and execute each command in order. This comes with Java 5.0 or later
    ExecutorService executorsQueue;

    public IndexEngineManagerImpl() {
        super();
        executorsQueue = Executors.newSingleThreadExecutor();
    }

    // clean resource when app ends
    public void destroy() {
        if (executorsQueue != null) {
            executorsQueue.shutdownNow();
        }
    }

    public MatchingItem searchMatchingItem(Item item) {
        throw new UnsupportedOperationException("Not supported yet.");
    }

    /** --------------- Inner classes -------------------------------------------------------------*/
    /**
     *
     */
    private abstract class AddContentTask implements Runnable {
        // these will be implemented in inherite class

        protected abstract Document getDocument();

        protected abstract void fireContentAddedEvent();
        // excute index adding process

        public void run() {
            Document document = getDocument();
            if (document == null) {
                return;
            }

            // TODO process to add document to index engine
            // ...

            // fire event
            fireContentAddedEvent();
        }
    }

    /**
     *
     * @author YOPCO
     *
     */
    private abstract class RemoveContentTask implements Runnable {
        // these will be implemented in inherite class

        protected abstract Document getDocument();

        protected abstract boolean deleteIndexItem();

        protected abstract void fireContentRemovedEvent();
        // excute index adding process

        public void run() {
            // delete index
            deleteIndexItem();
            // fire event
            fireContentRemovedEvent();
        }
    }

    /**
     *
     * @author YOPCO
     *
     */
    private class AddItemTask extends AddContentTask {

        private final long itemID;

        public AddItemTask(long itemID) {
            this.itemID = itemID;
        }

        @Override
        public Document getDocument() {
            Document document = null;
          
            document = IndexEngineManagerImpl.this.addItemIndex(itemID);
           
            return document;
        }

        @Override
        public void fireContentAddedEvent() {
            // TODO: invoke MatchingDispatcher to fire matching event if item is Want/Sell
           
        }
    }

    /**
     *
     * @author YOPCO
     *
     */
    private class RemoveItemTask extends RemoveContentTask {

        private final long itemID;

        public RemoveItemTask(long itemID) {
            this.itemID = itemID;
        }

        @Override
        public Document getDocument() {
            Document document = null;
            //TODO	add process here

            return document;
        }

        @Override
        public void fireContentRemovedEvent() {
           // executeMatchingEngine(itemID, MatchingEvent.ITEM_DELETED);
        }

        @Override
        protected boolean deleteIndexItem() {
            return IndexEngineManagerImpl.this.deleteItemIndex(itemID);
        }
    }

    /** --------------- Operations ----------------------------------------------------------------*/
    private void addToIndex(Runnable addToIndexTask) {
        executorsQueue.execute(addToIndexTask);
    }

    public void addItemToIndex(long itemID) {
        addToIndex(new AddItemTask(itemID));
    }

    public void removeItemFromIndex(long itemID) {
        addToIndex(new RemoveItemTask(itemID));
    }

    public void updateItemToIndex(long itemID) {
        addToIndex(new RemoveItemTask(itemID));
        addToIndex(new AddItemTask(itemID));
    }

    private void executeMatchingEngine(long itemID, int matchingEventType) {
//        final MatchingEvent matchingEvent = new MatchingEvent(matchingEventType, new HashMap<Object, Object>(), DateUtils.now(), itemID);
//        // run matching engine in independent thread
//        new Thread() {
//
//            @Override
//            public void run() {
//                MatchingEventDispatcher.getInstance().dispatchEvent(matchingEvent);
//            }
//        }.run();
    }

    /**
     *
     */
    public synchronized void buildItemIndex() {
        log.info("Begin building Item Index ...");

        Directory newDirectory;
        //TODO check is ready for indexing

        log.info((new StringBuilder()).append("Search indexer rebuild task started at ").append(new Date()).toString());
        newDirectory = null;
        String newDirName;
        IndexWriter writer = null;;
        File searchDir;
        do {
            String jiveHome = "";
            File mainDir = new File((new StringBuilder()).append(jiveHome).append(File.separator).append("search").toString());
            newDirName = "yopco-item";
            searchDir = new File(mainDir, newDirName);
        } while (searchDir.exists());
        searchDir.mkdir();
        try {
            newDirectory = FSDirectory.open(searchDir);
        } catch (IOException ex) {
            Logger.getLogger(IndexEngineManagerImpl.class.getName()).log(Level.SEVERE, null, ex);
        }
 
        try {
            try {
                writer = new IndexWriter(newDirectory, new StandardAnalyzer(Version.LUCENE_CURRENT), true, IndexWriter.MaxFieldLength.LIMITED);
                writer.setUseCompoundFile(false);
                indexItems(writer);
                writer.optimize();
            } catch (IOException e) {
                e.printStackTrace();
                log.error(e.getMessage());
            }
            return;
        } finally {
            try {
                if (writer != null) {
                    writer.close();
                }
            } catch (IOException e) {
                log.error(e.getMessage());
            }
        }
    }

    private void indexItems(IndexWriter indexWriter) {
        List<Long> list = this.getAllItemIDs();
//        for (Long itemID : list) {
//            DbItem dbItem;
//            try {
//                dbItem = new DbItem(itemID);
//                try {
//                    indexWriter.addDocument(LuceneDocumentMapper.ItemToDocument(dbItem));
//                } catch (CorruptIndexException e) {
//                    log.error(e.getMessage(), e);
//                    e.printStackTrace();
//                } catch (IOException e) {
//                    log.error(e.getMessage(), e);
//                    e.printStackTrace();
//                }
//            } catch (BlogPostNotFoundException e) {
//                log.error(e.getMessage(), e);
//            }
//        }
    }

    public Document addItemIndex(long itemID)  {
        Directory indexDirectory = getIndexDirectory();
//        DbItem dbItem = null;
//        try {
//            dbItem = new DbItem(itemID);
//        } catch (BlogPostNotFoundException e) {
//            log.error(e.getMessage(), e);
//            throw e;
//        }
//        try {
//            if (!IndexReader.isLocked(indexDirectory)) {
//                IndexWriter indexWriter = new IndexWriter(indexDirectory, new StandardSynonymAnalyzer(), false);
//                Document document = LuceneDocumentMapper.ItemToDocument(dbItem);
//                indexWriter.addDocument(document);
//                indexWriter.optimize();
//                indexWriter.close();
//                log.info(" -- build index DONE for itemID: " + itemID);
//                return document;
//            } else {
//                log.info(" -- INDEX DIRECTORY IS LOCKED, can not build index for itemID " + itemID);
//            }
//        } catch (CorruptIndexException e) {
//            log.error(e.getMessage(), e);
//        } catch (LockObtainFailedException e) {
//            log.error(e.getMessage(), e);
//        } catch (IOException e) {
//            log.error(e.getMessage(), e);
//        }
        return null;
    }

    public void rebuildIndexForItem(long itemID)  {
        deleteItemIndex(itemID);
        addItemIndex(itemID);
    }

    public boolean deleteItemIndex(long itemID) {
        Directory indexDirectory = getIndexDirectory();
        int rs = 0;

        try {
            if (IndexReader.indexExists(indexDirectory)) {
                IndexReader indexReader = IndexReader.open(indexDirectory);
                Term deletionTerm = new Term(ITEM_ID, itemID + "");
                rs = indexReader.deleteDocuments(deletionTerm);
                indexReader.close();
                log.info(rs + " removed doc. deleteItemIndex DONE for itemID: " + itemID);
            } else {
                log.info(" -- INDEX DIRECTORY IS LOCKED, can not deleteItemIndex for itemID " + itemID);
            }
        } catch (IOException e) {
            log.error(e.getMessage());
        }
        return rs == 1;
    }

    /**
     *
     */
    public synchronized void buildExternalItemIndexMatching(String username, List<ExternalItem> externalItems) {
        log.info("Begin building External Item Index ...");

        Directory newDirectory;
        //TODO check is ready for indexing
        log.info((new StringBuilder()).append("ExternalMatching task started at ").append(new Date()).toString());
        newDirectory = null;
        String newDirName;
        IndexWriter writer = null;
        File searchDir;

        do {
            String jiveHome = "";//FIXME
            File mainDir = new File((new StringBuilder()).append(jiveHome).append(File.separator).append("search").toString());
            newDirName = username;
            searchDir = new File(mainDir, newDirName);
        } while (searchDir.exists());

        searchDir.mkdir();
        try {
            newDirectory = FSDirectory.open(searchDir);
        } catch (IOException e) {
            log.error(e.getMessage());
            e.printStackTrace();
        }

        try {
            try {
                writer = new IndexWriter(newDirectory, new StandardAnalyzer(Version.LUCENE_CURRENT), true, IndexWriter.MaxFieldLength.LIMITED);
                writer.setUseCompoundFile(true);
                try {
                    for (ExternalItem externalItem : externalItems) {
                        writer.addDocument(LuceneDocumentMapper.ExternalItemToDocument(externalItem));
                    }
                } catch (CorruptIndexException e) {
                    log.error(e.getMessage());
                    e.printStackTrace();
                }
            } catch (IOException e) {
                e.printStackTrace();
                log.error(e.getMessage());
            }
            return;
        } finally {
            try {
                if (writer != null) {
                    writer.close();
                }
            } catch (IOException e) {
                log.error(e.getMessage());
            }
        }
    }


}
