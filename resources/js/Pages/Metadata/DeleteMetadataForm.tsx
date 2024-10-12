import { Button, Flex, Modal, Text } from "@mantine/core";
import React, { FormEventHandler } from "react";
import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";
import { Metadata } from "@/types";

interface IProps {
    isOpened: boolean;
    close: () => void;
    metadata?: Metadata;
}

const DeleteMetadataForm: React.FC<IProps> = ({ isOpened, close, metadata }) => {
    const { processing, delete: destroy, reset } = useForm();

    const deletemetadataubmit: FormEventHandler = (e) => {
        e.preventDefault();

        destroy(route("metadata.destroy", metadata?.id), {
            onSuccess: () => {
                close();
                notifications.show({
                    message: "Metadata deleted successfully",
                    color: "red",
                });
            },
            onError: () => {
                close();
                notifications.show({
                    message: "Something went wrong",
                    color: "red",
                });
            },
            onFinish: () => reset(),
        });
    };

    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={<Text size="lg">Delete Metadata</Text>}
            size={550}
        >
            <form onSubmit={deletemetadataubmit}>
                <Text c="dimmed" mt={4} size="sm">
                    Delete this metadata {metadata?.name}?
                </Text>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="subtle" color="gray" onClick={close}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing} color="red">
                        Confirm Delete
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

export default DeleteMetadataForm;