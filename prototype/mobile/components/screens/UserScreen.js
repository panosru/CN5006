import React, {useEffect, useState} from "react";
import {ActivityIndicator, Button, FlatList, Image, Pressable, StyleSheet, Text, TextInput, View} from "react-native";
import {isLogged, login, logout, getToken} from '../../utils/Auth';
import LinearGradient from "react-native-linear-gradient";
import {fetch} from "react-native/Libraries/Network/fetch";
import TicketCard from "../cards/TicketCard";
import {useFocusEffect} from "@react-navigation/native";
import dayjs from "dayjs";
import relativeTime from 'dayjs/plugin/relativeTime';


const UserScreen = {
    Profile : ({navigation, route}) => {
        const [isLoading, setLoading] = useState(true);
        const [data, setData] = useState([]);

        const getProfile = async () => {
            try {
                let response = await fetch(`${global.store.BASE_URL}/user/tickets`, {
                    method: 'GET',
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                        Authorization: `bearer ${getToken()}`
                    }
                });

                let responseJson = await response.json();
                setData(responseJson);
            } catch (e) {
                console.error(e);
            } finally {
                setLoading(false);
            }
        }

        useFocusEffect(
            React.useCallback(() => {
                if (!isLogged())
                    navigation.navigate('Login');

                getProfile();

                const unsubscribe = () => {
                    setLoading(true);
                    setData([]);
                }

                return () => unsubscribe();
            }, [])
        )

        const RenderTicketItem = ({item}) => (
            <TicketCard key={item.id} item={item} />
        );

        dayjs.extend(relativeTime);

        return (
            <View style={styles.profileContainer}>
                <LinearGradient
                    colors={['transparent', 'rgba(0,0,0,0.3)', '#831d19']}
                    style={styles.linearGradient}
                />
                {isLoading ? (
                    <ActivityIndicator />
                ) : (
                    <>
                        <View style={styles.card}>
                            <View style={styles.cardInfo}>
                                <Text style={styles.cardTitle}>{data?.full_name}</Text>
                                <Text style={styles.cardDesc}>
                                    Member for {dayjs(data?.created_at).toNow(true)} • Total tickets: {data?.tickets?.length}
                                </Text>
                            </View>
                        </View>
                        <FlatList
                            data={data?.tickets}
                            keyExtractor={item => item.id}
                            renderItem={RenderTicketItem}
                        />
                    </>
                )}
            </View>
        );
    },

    Auth : ({navigation, route}) => {

        const checkCredentials = async (email, password) => {
            try {
                let response = await fetch(`${global.store.BASE_URL}/user/auth`, {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password
                    })
                });
                let responseJson = await response.json();
                console.log(responseJson);

                if ('success' === responseJson.status)
                    login(responseJson.token, responseJson.roles);

            } catch (error) {
                console.error(error);
            } finally {
                if (isLogged()) {
                    navigation.navigate('User');
                } else  {
                    navigation.navigate('Login', {message: 'Try again'})
                }
            }
        };

        useEffect(() => {
            checkCredentials(route.params.email, route.params.password);
        }, [route.params.email, route.params.password]);

        return (
            <View style={styles.container}>
                <LinearGradient
                    colors={['transparent', 'rgba(0,0,0,0.3)', '#831d19']}
                    style={styles.linearGradient}
                />
                <ActivityIndicator />
            </View>
        )
    },

    Login : ({navigation, route}) => {
        const [email, setEmail] = useState('');
        const [password, setPassword] = useState('');

        useEffect(() => {
            if (isLogged())
                navigation.navigate('Profile');
        }, []);

        return (
            <View style={styles.container}>
                <LinearGradient
                    colors={['transparent', 'rgba(0,0,0,0.3)', '#831d19']}
                    style={styles.linearGradient}
                />
                <View style={styles.inputWrapper}>
                    <TextInput
                        style={[styles.inputText]}
                        placeholder="Email"
                        placeholderTextColor={'#999'}
                        returnKeyType="next"
                        autoCapitalize="none"
                        autoComplete="email"
                        textContentType="emailAddress"
                        keyboardType="email-address"
                        onChangeText={(email) => setEmail(email)}
                        autoFocus={true}/>
                </View>
                <View style={styles.inputWrapper}>
                    <TextInput
                        style={[styles.inputText]}
                        placeholder="Password"
                        placeholderTextColor={'#999'}
                        returnKeyType="done"
                        onChangeText={(password) => setPassword(password)}
                        secureTextEntry={true}/>
                </View>
                <Pressable style={styles.loginBtn} onPress={() => {
                    navigation.navigate('Auth', {
                        email: email,
                        password: password
                    })
                }}>
                    <Text style={styles.loginText}>LOGIN</Text>
                </Pressable>
                {null !== route.params?.message ? (
                    <Text style={{marginTop: 10, color: '#ddd'}}>{route.params?.message}</Text>
                ) : null}
            </View>
        );
    }
}

const styles = StyleSheet.create({
    profileContainer: {
        flex: 1,
        padding: 20,
        paddingTop: 30,
        backgroundColor: '#831d19'
    },

    container: {
        flex: 1,
        padding: 20,
        paddingTop: 30,
        backgroundColor: '#831d19',
        alignItems: "center",
        justifyContent: "center"
    },
    linearGradient: {
        position: 'absolute',
        top: 0,
        left: 0,
        right: 0,
        height: '100%',
    },
    inputWrapper: {
        backgroundColor: '#ad241f',
        borderRadius: 5,
        width: '70%',
        height: 45,
        marginBottom: 20,
    },
    inputText: {
        color: '#fff',
        flex: 1,
        padding: 10,
        marginLeft: 20,
        height: 50,
    },
    loginBtn: {
        width: "40%",
        borderRadius: 4,
        borderWidth: 1,
        borderColor: '#ad241f',
        height: 50,
        alignItems: "center",
        justifyContent: "center",
        marginTop: 10,
        backgroundColor: '#ddd',
    },
    loginText: {
        color: '#ad241f',
        textAlign: 'center',
    },
    card: {
        backgroundColor: '#fff',
        flex: 1,
        marginTop: 30,
        marginBottom: 20,
        marginHorizontal: 24,
        paddingBottom: 20,
        borderRadius: 4,
        flexDirection:'row'
    },
    cardInfo: {
        padding: 10,
    },
    cardTitle: {
        fontSize: 20,
        fontWeight: '300',
        color: '#000',
        marginBottom: 5
    },
    cardDesc: {
        fontSize: 12,
        marginBottom: 5
    },
});

export default UserScreen;
