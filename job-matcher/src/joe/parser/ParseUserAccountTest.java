package joe.parser;

import java.io.ByteArrayInputStream;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.Reader;
import java.net.URL;
import java.util.logging.Level;
import java.util.logging.Logger;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.xpath.XPath;
import javax.xml.xpath.XPathConstants;
import javax.xml.xpath.XPathFactory;

import org.lobobrowser.html.UserAgentContext;
import org.lobobrowser.html.parser.HtmlParser;
import org.lobobrowser.html.test.SimpleUserAgentContext;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;

public class ParseUserAccountTest {
    protected String asp_net__VIEWSTATE = "";
    protected String asp_net__EVENTVALIDATION = "";

    public String getAsp_net__EVENTVALIDATION() {
        return asp_net__EVENTVALIDATION;
    }

    public String getAsp_net__VIEWSTATE() {
        return asp_net__VIEWSTATE;
    }

    public void setAsp_net__EVENTVALIDATION(String s) {
        this.asp_net__EVENTVALIDATION = s;
    }

    public void setAsp_net__VIEWSTATE(String s) {
        this.asp_net__VIEWSTATE = s;
    }
    


    private static final String TEST_URI = "file:///F:/test_joe_data/TblStudentListAction.aspx.html";
   // private static final String TEST_URI = "http://drdvn.com/admin/Default.aspx";

    public void parseHTMLStream(byte[] bytes) throws Exception {
        InputStream is = new ByteArrayInputStream(bytes);
         // Disable most Cobra logging.
        Logger.getLogger("org.lobobrowser").setLevel(Level.WARNING);
        UserAgentContext uacontext = new SimpleUserAgentContext();
        // In this case we will use a standard XML document
        // as opposed to Cobra's HTML DOM implementation.
        DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
        DocumentBuilder builder = factory.newDocumentBuilder();

        try {
            Reader reader = new InputStreamReader(is, "UTF-8");
            Document document = builder.newDocument();
            // Here is where we use Cobra's HTML parser.
            HtmlParser parser = new HtmlParser(uacontext, document);
            parser.parse(reader);
            // Now we use XPath to locate "a" elements that are
            // descendents of any "html" element.
            XPath xpath = XPathFactory.newInstance().newXPath();

            NodeList nodeList = (NodeList) xpath.evaluate("html//table[@id='ctl00_ContentPlaceHolder1_StudentList']//tr", document, XPathConstants.NODESET);
            int length = nodeList.getLength();
            System.out.println("# Row: " + length);
            for(int i = 0; i < length; i++) {
                Element element = (Element) nodeList.item(i);
                NodeList td_list = element.getElementsByTagName("td");
                int td_list_length = td_list.getLength();
                System.out.println("td_list.getLength() " + td_list_length);
                if(td_list_length == 7)
                {
                    for(int j=0; j < td_list_length; j++){
                        if(j==0 || j == (td_list_length-1)){
                            continue;
                        }
                        else
                        {
                            String text = ((Element) td_list.item(j)).getTextContent();
                           
                            System.out.println(j +" : "+text.trim());
                            
                        }
                    }
                    System.out.println("#");
                }
            }

            String path_viewstate = "//*[@id='__VIEWSTATE']";
            Node node_viewstate = (Node) xpath.evaluate(path_viewstate, document, XPathConstants.NODE);
            if (node_viewstate != null) {
                this.asp_net__VIEWSTATE = node_viewstate.getAttributes().getNamedItem("value").getNodeValue();
            }

            String path_event = "//*[@id='__EVENTVALIDATION']";
            Node node_event = (Node) xpath.evaluate(path_event, document, XPathConstants.NODE);
            if (node_event != null) {
                this.asp_net__EVENTVALIDATION = node_event.getAttributes().getNamedItem("value").getNodeValue();
            }
        } finally {
            is.close();
        }
       // System.out.println("\n\n"+ new String(bytes));
    }

    public static void main(String[] args) throws Exception {
        // Disable most Cobra logging.
        Logger.getLogger("org.lobobrowser").setLevel(Level.WARNING);
        UserAgentContext uacontext = new SimpleUserAgentContext();
        // In this case we will use a standard XML document
        // as opposed to Cobra's HTML DOM implementation.
        DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
        DocumentBuilder builder = factory.newDocumentBuilder();
        URL url = new URL(TEST_URI);
        InputStream in = url.openConnection().getInputStream();
        try {
            Reader reader = new InputStreamReader(in, "UTF-8");
            Document document = builder.newDocument();
            // Here is where we use Cobra's HTML parser.
            HtmlParser parser = new HtmlParser(uacontext, document);
            parser.parse(reader);
            // Now we use XPath to locate "a" elements that are
            // descendents of any "html" element.
            XPath xpath = XPathFactory.newInstance().newXPath();


//            String path_viewstate = "//*[@id='__VIEWSTATE']";
//            Node node_viewstate = (Node) xpath.evaluate(path_viewstate, document, XPathConstants.NODE);
//            if (node_viewstate != null) {
//                System.out.println(node_viewstate.getAttributes().getNamedItem("value").getNodeValue());
//            }
//
//            String path_event = "//*[@id='__EVENTVALIDATION']";
//            Node node_event = (Node) xpath.evaluate(path_event, document, XPathConstants.NODE);
//            if (node_event != null) {
//                System.out.println(node_event.getAttributes().getNamedItem("value").getNodeValue());
//            }




            
            NodeList nodeList = (NodeList) xpath.evaluate("html//table[@id=\"ctl00_ContentPlaceHolder1_StudentList\"]//tr", document, XPathConstants.NODESET);
            int rowNum = nodeList.getLength() - 3;
            int columnNum = 5;
            int startRow = 3, startCol = 2;
            System.out.println(rowNum);
            StringBuilder data = new StringBuilder();
            for (int i = 0; i < rowNum;) {
//                Element element = (Element) nodeList.item(i);
//                System.out.println("## Anchor # " + i + ": " + element.getTextContent());
                String path = "/html/body/table/tbody/tr/td/table/tbody/tr[7]/td/form/table/tbody/tr/td[3]/div/div/table/tbody/tr[" + startRow + "]/td[" + startCol + "]";
                             ///html/body/table/tbody/tr/td/table/tbody/tr[7]/td/form/table/tbody/tr/td[3]/div/div/table/tbody/tr[3]/td[2]
                Node node_td = (Node) xpath.evaluate(path, document, XPathConstants.NODE);
                if (node_td != null) {
                    data.append(node_td.getTextContent()).append("$");
                }

                startCol++;
                if (startCol > 6) {
                    data.append("\n");
                    startCol = 2;
                    startRow++;
                    i++;
                }
            }
            System.out.println(data.toString());


        } finally {
            in.close();
        }
    }
}
