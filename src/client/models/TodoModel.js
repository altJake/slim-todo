var $ = require('jquery');

export class TodoModel {
	constructor() {
		this.modelUri = '/api/v1/todo/';
		this.onChanges = [];
		this.todos = [];

		this.get();
	}

	subscribe(onChange) {
		this.onChanges.push(onChange)
	}

	inform() {
		this.onChanges.forEach(function (cb) { cb(); });
	}

	get() {
		$.ajax({
      type: 'GET',
      dataType: 'json',
      url: this.modelUri,
      success: (data) => {
				this.todos = data;
				this.inform();
			},
      error: (error) => alert(JSON.stringify(error))
    });
	}

	add(subject, categories = []) {
		$.ajax({
      type: 'PUT',
      dataType: 'json',
      url: this.modelUri,
      data: { subject: subject, categories: categories },
      success: (data) => {
        this.todos = this.todos.concat(data);
        this.inform();
      },
      error: (error) => alert(JSON.stringify(error))
    });
	}

	update(todoToUpdate, updates) {
		$.ajax({
      type: 'POST',
      dataType: 'json',
      url: this.modelUri,
      data: Object.assign(todoToUpdate, updates),
      success: (data) => {
        this.todos = this.todos.map((todo) => {
    			return todo !== todoToUpdate ? todo : data;
    		});

    		this.inform();
      },
      error: (error) => alert(JSON.stringify(error))
    });
	}

	delete(todo) {
    $.ajax({
      type: 'DELETE',
      dataType: 'json',
      url: this.modelUri + todo.id,
      success: () => {
        this.todos = this.todos.filter((candidate) => {
    			return candidate !== todo;
    		});

    		this.inform();
      },
			error: (error) => alert(JSON.stringify(error))
    });
	}
}
