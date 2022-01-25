import {
    ActivityIndicator,
    FlatList,
    Pressable, StyleSheet, View,
} from 'react-native';
import React, {useState} from 'react';
import MovieCard from "../cards/MovieCard";
import {useFocusEffect} from "@react-navigation/native";
import LinearGradient from 'react-native-linear-gradient';

const MoviesScreen = ({navigation, route}) => {
  const [isLoading, setLoading] = useState(true);
  const [data, setData] = useState([]);

  const getMovies = async id => {
    try {
      let response = await fetch(`${global.store.BASE_URL}/movies`);
      let responseJson = await response.json();
      setData(responseJson);
    } catch (error) {
      console.error(error);
    } finally {
      setLoading(false);
    }
  };

  console.log(global.demo);


  useFocusEffect(
      React.useCallback(() => {
        getMovies().then();

        const unsubscribe = () => {
          setLoading(true);
          setData([]);
        };

        return () => unsubscribe();
      }, []),
  );

  const RenderListItem = ({item}) => (
      <Pressable
      onPress={() => {
        navigation.navigate('Movie', {id: item.id});
      }}>
        <MovieCard key={item.id} item={item} />
    </Pressable>
  );

  return (
    <View style={styles.container}>
        <LinearGradient
            colors={['transparent', 'rgba(0,0,0,0.3)', '#831d19']}
            style={styles.linearGradient}
        />
      {isLoading ? (
        <ActivityIndicator />
      ) : (
        <FlatList
          data={data}
          keyExtractor={item => item.id}
          renderItem={RenderListItem}
        />
      )}
    </View>
  );
};

const styles = StyleSheet.create({
    container: {
        flex: 1,
        padding: 20,
        paddingTop: 30,
        backgroundColor: '#831d19',
    },
    linearGradient: {
        position: 'absolute',
        top: 0,
        left: 0,
        right: 0,
        height: '100%',
    }
});

export default MoviesScreen;
