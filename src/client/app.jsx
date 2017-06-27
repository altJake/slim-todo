import React from 'react';
import {render} from 'react-dom';

import {CategoryModel} from './models/CategoryModel';
import {TodoModel} from './models/TodoModel';

import {TodoItem} from './items/todoItem.jsx';

var ENTER_KEY = 13;

class App extends React.Component {
  constructor() {
    super();
    this.state = {
      editing: null,
      newTodo: ''
    };
  }

  handleChange(event) {
    this.setState({newTodo: event.target.value});
	}

  handleNewTodoKeyDown(event) {
    if (event.keyCode !== ENTER_KEY) {
    	return;
    }

    event.preventDefault();

    var val = this.state.newTodo.trim();

    if (val) {
    	this.props.model.add(val);
    	this.setState({newTodo: ''});
    }
	}

  toggle(todo) {
    this.props.model.update(todo, { isDone: !todo.isDone });
  }

  delete(todo) {
    this.props.model.delete(todo);
  }

  edit(todo) {
    this.setState({ editing: todo.id });
  }

  save(todo, subject) {
    this.props.model.update(todo, { subject: subject });
    this.setState({editing: null});
  }

  cancel() {
    this.setState({editing: null});
  }

  render () {
    var main;
    var todos = this.props.model.todos;

    var todoItems = todos.map(todo => {
      return (
        <TodoItem
          key={todo.id}
          todo={todo}
          onToggle={this.toggle.bind(this, todo)}
          onDelete={this.delete.bind(this, todo)}
          onEdit={this.edit.bind(this, todo)}
          editing={this.state.editing === todo.id}
          onSave={this.save.bind(this, todo)}
          onCancel={this.cancel.bind(this)}
        />
      );
    }, this);

    if (todos.length) {
      main = (
        <section className="list-holder">
          <ul className="todo-list">
            {todoItems}
          </ul>
        </section>
      );
    }

    return (
      <div>
        <h2>Do To</h2>
        <header className="header">
          <input
            className="new-todo-input"
            placeholder="What shall we do today?"
            value={this.state.newTodo}
            onKeyDown={this.handleNewTodoKeyDown.bind(this)}
            onChange={this.handleChange.bind(this)}
            autoFocus={true}
          />
        </header>
        {main}
      </div>
    );
  }
}

var model = new TodoModel();
model.subscribe(() => render(<App model={model} />, document.getElementsByClassName('app')[0]));
