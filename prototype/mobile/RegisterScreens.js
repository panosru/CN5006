import React, {useEffect, useReducer, useState} from 'react';
import {NavigationContainer} from '@react-navigation/native';
import {createBottomTabNavigator} from '@react-navigation/bottom-tabs';
import MoviesScreen from './components/screens/MoviesScreen';
import MovieScreen from './components/screens/MovieScreen';
import {iconsMap, iconsLoaded} from './utils/AppIcons';
import Icon from 'react-native-vector-icons/Ionicons';
import {ActivityIndicator, Image, Text} from 'react-native';
import {createNativeStackNavigator} from "@react-navigation/native-stack";
import UserScreen from "./components/screens/UserScreen";

const Tab = createBottomTabNavigator();
const Stack = createNativeStackNavigator();

function RegisterScreens() {
  const [isLoading, setIsLoading] = useState(true);

  global.store = {
      BASE_URL: 'http://10.0.2.2:3002/api'
  };

  try {
    iconsLoaded().then(() => setIsLoading(false));
  } catch (error) {
    console.log(error);
  }

  return (
    <NavigationContainer>
      {isLoading ? (
        <ActivityIndicator />
      ) : (
        <Tab.Navigator
          screenOptions={({route}) => ({
            tabBarIcon: ({focused, color, size}) => {
              let icon;

              if (route.name === 'Cinema') {
                icon = focused ? 'md-videocam' : 'md-videocam';
              } else if (route.name === 'Profile') {
                icon = focused ? 'person' : 'person';
              }

              // You can return any component that you like here!
              return <Icon name={icon} size={size} color={color} />;
              //return <Image source={icon} />;
            },
            headerShown: false,
            tabBarActiveBackgroundColor: '#ad241f',
            tabBarInactiveBackgroundColor: '#ad241f',
            tabBarActiveTintColor: '#ddd',
            tabBarInactiveTintColor: '#000',
            tabBarStyle: {
              borderTopColor: '#831d19',
              backgroundColor: '#831d19'
            },
            tabBarLabelStyle: {
              paddingBottom: 5
            }
          })}>
          <Tab.Screen name="Cinema" component={CinemaScreen} />
          <Tab.Screen name="Profile" component={ProfileScreen} />
        </Tab.Navigator>
      )}
    </NavigationContainer>
  );
}

export const CinemaScreen = () => {
  return (
      <Stack.Navigator screenOptions={{
        headerShown: false
      }}>
        <Stack.Screen name="Movies" component={MoviesScreen} />
        <Stack.Screen name="Movie" component={MovieScreen} />
      </Stack.Navigator>
  );
}

export const ProfileScreen = () => {
    return (
        <Stack.Navigator screenOptions={{
            headerShown: false
        }}>
            <Stack.Screen name="User" component={UserScreen.Profile} />
            <Stack.Screen name="Login" component={UserScreen.Login} />
            <Stack.Screen name="Auth" component={UserScreen.Auth} />
        </Stack.Navigator>
    );
}

export default RegisterScreens;
