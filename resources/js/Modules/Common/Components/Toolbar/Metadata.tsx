import { Button } from "@mantine/core";
import { IconDeviceSdCard } from "@tabler/icons-react";

const MetadataButton = () => {
    return (
        <>
            <Button
                variant="subtle"
                color="dark.3"
                leftSection={<IconDeviceSdCard size={18} />}
            >
                Metadata
            </Button>
        </>
    );
};

export default MetadataButton;
