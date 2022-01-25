import React, {useEffect, useState} from 'react';
import {
  ActivityIndicator,
  Image,
  ScrollView, StatusBar,
  StyleSheet,
  Text,
  TouchableOpacity,
  View,
} from 'react-native';
import Icon from 'react-native-vector-icons/Ionicons';
const {ToolbarAndroid} = Icon;
import {iconsMap} from '../../utils/AppIcons';
import LinearGradient from 'react-native-linear-gradient';
import {useFocusEffect} from '@react-navigation/native';
import {RegisterMovieScreens} from "../../RegisterScreens";

const MovieScreen = ({navigation, route}) => {
  const [isLoading, setLoading] = useState(true);
  const [data, setData] = useState([]);

  const getMovies = async id => {
    try {
      let response = await fetch(`${global.store.BASE_URL}/movies/${id}`);
      let responseJson = await response.json();
      setData(responseJson);
    } catch (error) {
      console.error(error);
    } finally {
      setLoading(false);
    }
  };

  useFocusEffect(
    React.useCallback(() => {
      getMovies(route.params.id);

      const unsubscribe = () => {
        setLoading(true);
        setData([]);
      };

      return () => unsubscribe();
    }, [route.params.id]),
  );

  return (
    <View style={styles.container}>
      {isLoading ? (
        <ActivityIndicator />
      ) : (
        <ScrollView>
          <View style={styles.trailer}>
            <Image source={{uri: data.image}} style={styles.imageTrailer} />
            <LinearGradient
              colors={['transparent', 'rgba(0,0,0,0.3)', '#000']}
              style={styles.linearGradient}
            />
          </View>

          <View style={styles.card}>
            <View style={styles.cardPanel}>
              <Text style={styles.cardTitle}>{data.title}</Text>
              <Text style={styles.cardDesc}>
                <Icon name="md-megaphone" /> {data.directors.join(', ')} {'\n'}
                <Icon name="md-pricetag" /> {data.genres.join(', ')} {'\n'}
                <Icon name="md-star" /> {data.rating}
              </Text>
            </View>
            <View style={styles.cardAction}>
              <TouchableOpacity style={styles.cardButton} onPress={() => {
                navigation.navigate('Schedule', {});
              }}>
                <View style={[styles.cardButtonView, styles.activeButton]}>
                  <Text style={[styles.cardButtonText, styles.activeText]}>
                    SCHEDULE
                  </Text>
                </View>
              </TouchableOpacity>
            </View>
            <View style={styles.cardDescription}>
              <Text>{data.plot}</Text>
            </View>
          </View>
          <View style={styles.cardThumb}>
            <Image source={{uri: data.image}} style={styles.cardImageThumb} />
          </View>
        </ScrollView>
      )}
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#000',
  },
  trailer: {
    height: 200,
  },
  imageTrailer: {
    height: 200,
    flex: 1,
  },
  linearGradient: {
    position: 'absolute',
    top: 0,
    left: 0,
    right: 0,
    height: 200,
  },
  card: {
    backgroundColor: '#fff',
    marginHorizontal: 24,
    borderRadius: 4,
    marginTop: -40,
    overflow: 'visible',
    paddingHorizontal: 3,
    paddingVertical: 10,
    marginBottom: 60,
  },
  cardThumb: {
    height: 160,
    width: 200,
    position: 'absolute',
    top: 130,
    left: 35,
    overflow: 'visible',
  },
  cardImageThumb: {
    height: 160,
    width: 120,
    borderRadius: 4,
  },
  cardPanel: {
    marginLeft: 138,
  },
  cardTitle: {
    textAlign: 'left',
    fontSize: 20,
    fontWeight: '300',
    color: '#000',
    marginBottom: 5,
  },
  cardDesc: {
    textAlign: 'left',
    fontSize: 12,
    marginBottom: 5,
    lineHeight: 18,
  },
  cardAction: {
    flexDirection: 'row',
    marginTop: 25,
    paddingVertical: 10,
    borderBottomWidth: 1,
    borderBottomColor: '#ddd',
  },
  cardButton: {
    flex: 1,
  },
  cardButtonView: {
    flex: 1,
    marginHorizontal: 8,
    borderWidth: 1,
    borderColor: '#ad241f',
    borderRadius: 4,
    paddingVertical: 10,
  },
  cardDescription: {
    padding: 10,
  },
  cardButtonText: {
    color: '#ad241f',
    textAlign: 'center',
  },
  activeButton: {
    backgroundColor: '#ad241f',
  },
  activeText: {
    color: '#fff',
  },
  playButton: {
    width: 60,
    height: 60,
    backgroundColor: '#ad241f',
    justifyContent: 'center',
    alignItems: 'center',
    borderRadius: 30,
  },
  playButtonContainer: {
    position: 'absolute',
    top: 40,
    right: 0,
    left: 0,
    justifyContent: 'center',
    alignItems: 'center',
  },
});

export default MovieScreen;
