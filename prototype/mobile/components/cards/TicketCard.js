import React, {Component} from 'react';
import {
    View,
    Text,
    StyleSheet,
    Image,
    ActivityIndicator,
    TouchableOpacity,
} from 'react-native';
import dayjs from "dayjs";

const TicketCard = (props, context) => {
    let {item} = props;
    console.log(item);

    return (
        <View style={styles.card}>
            <View style={styles.cardImage}>
                {item?.show?.movie?.image ?
                    <View style={{flex: 1}}>
                        <Image
                            source={{uri: item.show.movie.image}}
                            style={styles.cardImageView}
                            resizeMode={'cover'}
                        />
                    </View>
                    : <View
                        style={styles.cardImageViewPlaceholder}
                    />}
            </View>
            <View style={styles.cardInfo}>
                {item ?
                    <View>
                        <Text style={styles.cardTitle}>
                            {item.show.movie.title}
                        </Text>
                        <Text style={styles.cardDesc}>
                            Seat: {item.human_seat} • {dayjs(item.show.datetime).format('dddd D MMM @ HH:mm')}
                        </Text>
                    </View>
                    : <ActivityIndicator animating={true} size="large"/>}
            </View>
        </View>
    )
};

const styles = StyleSheet.create({
    card: {
        backgroundColor: '#fff',
        flex: 1,
        marginTop: 30,
        marginBottom: 20,
        marginHorizontal: 24,
        borderRadius: 4,
        flexDirection:'row'
    },
    cardInfo: {
        padding: 10,
        justifyContent: 'center',
        alignItems: 'center',
        width: 250,
        height: 70
    },
    cardTitle: {
        textAlign: 'center',
        fontSize: 20,
        fontWeight: '300',
        color: '#000',
        marginBottom: 5
    },
    cardDesc: {
        textAlign: 'center',
        fontSize: 12,
        marginBottom: 5
    },
    cardImage: {
        flex: 1,
        flexDirection: 'column',
        width: 75,
        height: 120,
        marginLeft: -20,
        marginTop: -20,
        marginBottom: -10,
        borderRadius: 4
    },
    cardImageView: {
        flex: 1,
        borderTopLeftRadius: 4,
        borderTopRightRadius: 4,
    },
    cardImageViewPlaceholder: {
        flex: 1,
        borderTopLeftRadius: 4,
        borderTopRightRadius: 4,
        backgroundColor: '#ddd',
    }
});


export default TicketCard;
