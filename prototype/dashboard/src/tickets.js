import * as React from "react";
import {
    Datagrid, DateField,
    List, TextField, EditButton,
    DeleteButton, Edit, Create,
    SimpleForm, NumberInput,
    TextInput, DateTimeInput,
    ReferenceInput, SelectInput, useRedirect
} from "react-admin";
import dayjs from "dayjs";

const SeatNumber = ({ record }) => {
    let row = String.fromCharCode((record?.row - 1) + 65);
    return <span>{row} {record?.seat}</span>;
};
const ShowTime = ({ record }) => {
    return <span>{dayjs(record?.show?.datetime).format('dddd D MMM @ HH:mm')}</span>
}
export const TicketList = props => (
    <List {...props}>
        <Datagrid rowClick="edit">
            <TextField source="show.movie.title" label="Movie" />
            <TextField source="show.hall_number" label="Hall" />
            <SeatNumber label="Seat" />
            <ShowTime label="Play Time" />
            <TextField source="user.full_name" label="Customer" />
            <DateField source="created_at" label="Booked at" />
            <DateField source="updated_at" />
            <EditButton />
            <DeleteButton />
        </Datagrid>
    </List>
);

const EditTitle = ({ record }) => {
    return <span>Edit Ticket: {record ? `${record.user.full_name} [ ${record.show.movie.title} | ${dayjs(record.show.datetime).format('dddd D MMM @ HH:mm')} - Hall: ${record.show.hall_number} ]` : ''}</span>;
};
export const TicketEdit = props => (
    <Edit title={<EditTitle />} {...props}>
        <SimpleForm>
            <SeatsSelection source="seat" />
            <RowsSelection source="row" />
        </SimpleForm>
    </Edit>
);

const ShowTitle = ({ record }) => {
    return <span>Ticket {record ? `${record.movie.title} | ${dayjs(record.datetime).format('dddd D MMM @ HH:mm')} - Hall: ${record.hall_number}` : ''}</span>;
};
const SeatsSelection = ({ source, record = {} }) => {
    let choices = Array.from(Array(record?.show?.hall?.seats_per_row ?? 10)).map((e,i) => ({id : i + 1, name : (i + 1).toString()}));

    return (
        <SelectInput
            source={source}
            choices={choices}
        />
    );
};
const RowsSelection = ({ source, record = {} }) => {
    let choices = Array.from(Array(record?.show?.hall?.rows ?? 26)).map((e,i) => ({id : i + 1, name : String.fromCharCode(i + 65)}));

    return (
        <SelectInput
            source={source}
            choices={choices}
        />
    );
};
export const TicketCreate = props => {

    const redirect = useRedirect();
    const onSuccess = () => {
        redirect('/tickets');
    };

    return (
        <Create onSuccess={onSuccess} {...props}>
            <SimpleForm>
                <SeatsSelection source="seat" />
                <RowsSelection source="row" />
                <ReferenceInput label="Show" reference="shows-future" source="show_id">
                    <SelectInput optionText={<ShowTitle />} optionValue="id" />
                </ReferenceInput>
                <ReferenceInput label="User" reference="users" source="user_id">
                    <SelectInput optionText="full_name" optionValue="id" />
                </ReferenceInput>
            </SimpleForm>
        </Create>
    );
};
