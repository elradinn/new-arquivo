import { Link } from "@inertiajs/react";
import { Button } from "@mantine/core";
import { IconAdjustments } from "@tabler/icons-react";
import React from "react";

interface IProps {
    folderId?: number;
}

const PropertiesButton: React.FC<IProps> = ({ folderId }) => {
    return (
        <>
            <Button
                variant="subtle"
                component={Link}
                href={`/folder/edit/${folderId}`}
                color="dark.3"
                leftSection={<IconAdjustments size={18} />}
            >
                Properties
            </Button>
        </>
    );
};

export default PropertiesButton;
