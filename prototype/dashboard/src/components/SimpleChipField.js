import React from 'react';
import Chip from '@material-ui/core/Chip';
import { makeStyles } from '@material-ui/core';

const useStyles = makeStyles({
    main: {
        display: 'flex',
        flexWrap: 'wrap',
        marginTop: 0,
        marginBottom: 0,
    },
    chip: { margin: 4 },
});

const SimpleChipField = ({ record }) => {
    const classes = useStyles();

    return record ? (
        <span className={classes.main}>
            <Chip
                key={record}
                className={classes.chip}
                label={record}
            />
        </span>
    ) : null;
};

SimpleChipField.defaultProps = {
    addLabel: true,
};

export default SimpleChipField;
