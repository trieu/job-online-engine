/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package php_builder;

/**
 *
 * @author Nguyen Tan Trieu
 */
public class testString {

    public static void main(String[] args) {
        String s = "{}";
        if(s.length() > 2){
            s = s.substring(0, s.lastIndexOf("}")) + ",\"class\":\"java.util.HashMap\"}";
        }
        else {
            s = s.substring(0, s.lastIndexOf("}")-1) + "\"class\":\"java.util.HashMap\"}";
        }
        System.out.println(s);
    }
}
