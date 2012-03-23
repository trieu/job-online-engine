/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package joe.search.base;

/**
 *
 * @author Nguyen Tan Trieu
 */
public class SimpleLog {
    String className = "";
    public SimpleLog(Class clazz) {
        className = clazz.getName();
    }

    public void info(Object o){
        System.out.println(className + " : " + o);
    }

    public void error(Object o){
        System.err.println(className + " : " + o);
    }


}
