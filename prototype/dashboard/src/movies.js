import * as React from "react";
import {
    List,
    EditButton,
    DeleteButton,
    Datagrid,
    TextField,
    EmailField,
    DateField,
    ImageField,
    ReferenceManyField,
    SingleFieldList,
    ChipField,
    Create,
    TextInput,
    SelectInput,
    Edit,
    SimpleForm,
    PasswordInput,
    CheckboxGroupInput,
    ReferenceInput,
    ReferenceArrayInput,
    AutocompleteInput,
    ArrayField,
    ArrayInput,
    SimpleFormIterator,
    ImageInput, NumberField, NumberInput, useRedirect
} from 'react-admin';
import RichTextInput from 'ra-input-rich-text';
import humanizeDuration from "humanize-duration";
import dayjs from "dayjs";
import duration from "dayjs/plugin/duration";
import relativeTime from "dayjs/plugin/relativeTime";
import SimpleChipField from "./components/SimpleChipField";

dayjs.extend(duration);
dayjs.extend(relativeTime);
const MovieDuration = ({ record }) => <span>{humanizeDuration(dayjs.duration(record.duration, 'minutes').asMilliseconds())}</span>;
export const MovieList = props => (
    <List {...props}>
        <Datagrid rowClick="edit">
            <ImageField source="image" title="title" />
            <TextField source="title" />
            <TextField source="year" />
            <ArrayField source="genres">
                <SingleFieldList>
                    <SimpleChipField />
                </SingleFieldList>
            </ArrayField>
            <ArrayField source="stars">
                <SingleFieldList>
                    <ChipField source="name" />
                </SingleFieldList>
            </ArrayField>
            <ArrayField source="directors">
                <SingleFieldList>
                    <SimpleChipField />
                </SingleFieldList>
            </ArrayField>
            <MovieDuration source="duration" />
            <DateField source="created_at" label="Added at" />
            <DateField source="updated_at" />
            <EditButton />
            <DeleteButton />
        </Datagrid>
    </List>
);

const HiddenInput = ({ source, record = {} }) => {
    return <input type="hidden" name={source} value={record.image} />;
};
const EditTitle = ({ record }) => {
    return <span>Movie: {record ? `${record.title} (${record.year})` : ''}</span>;
};
export const MovieEdit = props => (
    <Edit title={<EditTitle />} {...props}>
        <SimpleForm>
            <TextInput source="title" />
            <TextInput source="year" />
            <NumberInput source="rating" />
            <TextInput source="trailer" />
            <NumberInput source="duration" label="Duration in minutes" />
            <RichTextInput source="plot" />
            <ArrayInput source="genres">
                <SimpleFormIterator>
                    <TextInput label="Genre" />
                </SimpleFormIterator>
            </ArrayInput>
            <ArrayInput source="stars">
                <SimpleFormIterator>
                    <TextInput source="name" label="Star" />
                    <HiddenInput source="image" />
                </SimpleFormIterator>
            </ArrayInput>
            <ArrayInput source="directors">
                <SimpleFormIterator>
                    <TextInput label="Director" />
                </SimpleFormIterator>
            </ArrayInput>
        </SimpleForm>
    </Edit>
);



const inputText = choice => choice.title;
const OptionRenderer = choice => (
    <span>
        <strong>{choice.record.title}</strong> - {choice.record.description} <br/>
        <img src={choice.record.image} width="120px" />
    </span>
);
const optionMatch = (filter, choice) => {
    return true;
};
export const MovieCreate = props => {

    const redirect = useRedirect();
    const onSuccess = () => {
        redirect('/movies');
    };

    return (
        <Create onSuccess={onSuccess} {...props}>
            <SimpleForm>
                <ReferenceInput reference="movies/find" label="Movie" source="id">
                    <AutocompleteInput optionText={<OptionRenderer />} matchSuggestion={optionMatch} inputText={inputText} />
                </ReferenceInput>
            </SimpleForm>
        </Create>
    );
}
