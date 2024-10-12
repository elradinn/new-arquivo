import { Button } from "@mantine/core";
import { IconTrashX } from "@tabler/icons-react";

const EmptyBinButton = () => {
    return (
        <Button
            variant="subtle"
            color="dark.3"
            leftSection={<IconTrashX size={18} />}
        >
            Empty Bin
        </Button>
    );
};

export default EmptyBinButton;
