import React, { FormEventHandler } from "react";
import { Button, Flex, Modal, Text } from "@mantine/core";
import { useForm } from "@inertiajs/react";
import { IconTrash } from "@tabler/icons-react";
import { useDisclosure } from "@mantine/hooks";
import { notifications } from "@mantine/notifications";
import { DeleteItemsData } from "@/Modules/Item/Types/DeleteItemsData";

interface DeleteButtonProps {
    all: boolean;
    ids?: string[];
}

interface DeleteModalProps {
    isOpened: boolean;
    close: () => void;
    deleteAll?: boolean;
    deleteIds?: string[];
}

const DeleteFilesForm: React.FC<DeleteModalProps> = ({
    isOpened,
    close,
    deleteAll,
    deleteIds,
}) => {
    const {
        data,
        delete: destroy,
        processing,
    } = useForm<DeleteItemsData>({
        ids: [],
    });


    const deleteFilesSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        data.ids = deleteIds ?? [];

        destroy(route("item.delete"), {
            onSuccess: () => {
                close();
                notifications.show({
                    message: "Files deleted",
                    color: "green",
                });
            },
            onError: (errors) => {
                let message = "";

                if (Object.keys(errors).length > 0) {
                    message = errors[Object.keys(errors)[0]];
                } else {
                    message = "Error during file deletion. Please try again later.";
                }

                notifications.show({
                    message,
                    color: "red",
                });
            },
        });
    };

    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={
                <Text fw="bold" size="lg">
                    Delete Files
                </Text>
            }
            size={550}
        >
            <form onSubmit={deleteFilesSubmit}>
                <Text c="dimmed">Delete selected files?</Text>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="subtle" onClick={close} color="gray">
                        Cancel
                    </Button>

                    <Button
                        ml={12}
                        type="submit"
                        loading={processing}
                        color="red"
                    >
                        Delete
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

const DeleteFilesButton: React.FC<DeleteButtonProps> = ({ all, ids }) => {
    const [
        deleteFilesOpened,
        { open: openDeleteFiles, close: closeDeleteFiles },
    ] = useDisclosure(false);

    return (
        <>
            <Button
                variant="subtle"
                color="dark.3"
                leftSection={<IconTrash size={18} />}
                onClick={openDeleteFiles}
            >
                Delete
            </Button>

            <DeleteFilesForm
                isOpened={deleteFilesOpened}
                close={closeDeleteFiles}
                deleteAll={false}
                deleteIds={ids}
            />
        </>
    );
};

export default DeleteFilesButton;
