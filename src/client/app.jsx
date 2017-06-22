import React from 'react';
import {render} from 'react-dom';

class App extends React.Component {
  render () {
    return <p> Hello Do To List!</p>;
  }
}

render(<App/>, document.getElementById('slim-todo'));
