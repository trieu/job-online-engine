
public class Hello {
	public Hello() {
		// TODO Auto-generated constructor stub
	}
	
	public void sayHi(String[] args) {
		if(args.length>0){
			System.out.println("Hi  "+args[0]);
		}
		else {
			System.out.println("Hi someone");
		}
	}
	
	public static void main(String[] args) {
		Hello hello = new Hello();
		hello.sayHi(args);
	}
}
