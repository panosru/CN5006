import React from 'react';
import RegisterScreens from './RegisterScreens';
import {fetch} from 'react-native/Libraries/Network/fetch';
import {StatusBar, View} from "react-native";

const App = () => {
  return (
      <View style={{flex: 1}}>
        <StatusBar
            translucent={true}
            backgroundColor="transparent"
            barStyle="light-content"
        />
        <RegisterScreens />
      </View>
  );
};

export default App;
