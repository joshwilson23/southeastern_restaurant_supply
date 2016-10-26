//Begin program


var todos = ["Buy dog food"];

var input = prompt("What would you like to do?");

while(input !== "quit") {
	
if (input === "list") { 
	listTodos();
}


else if(input === "new") {
	
	addTodo();

}
	else if(input === "delete"){
		deleteTodo();

	}
	
	input = prompt("What would you like to do?");
}

console.log("Ok, you quit.");
















function listTodos(){
	console.log("**********************")
todos.forEach(function(todo, index){
	console.log(index + ": " + todo);
});
	console.log("**********************")
}


function addTodo(){
		var newTodo = prompt("Enter new todo");
	
	todos.push(newTodo);
}



function deleteTodo(){
	//ask for index to be deleted
		var index = prompt("Enter index of todo to delete");
		//delete the todo
		//splice()
		todos.splice(index,1)

		//on delete
		console.log("Deleted todo")
}
