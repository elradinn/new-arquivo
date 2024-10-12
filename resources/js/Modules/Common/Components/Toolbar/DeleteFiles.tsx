import React, { FormEventHandler } from "react";
import { Button, Flex, Modal, Text } from "@mantine/core";
import { useForm, usePage } from "@inertiajs/react";
import { IconTrash } from "@tabler/icons-react";
import { PageProps } from "@/types";
import { useDisclosure } from "@mantine/hooks";
import { notifications } from "@mantine/notifications";

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

interface FormData {
    all: boolean;
    ids?: string[];
    parent_id?: number;
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
    } = useForm<FormData>({
        all: false,
        ids: [],
        parent_id: 0,
    });

    const parent_id = usePage<PageProps>().props.folder?.id;

    const deleteFilesSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        data.parent_id = parent_id;

        if (deleteAll) {
            data.all = true;
        } else {
            data.ids = deleteIds;
        }

        destroy(route("file.delete"), {
            onSuccess: () => {
                close();
                notifications.show({
                    message: "Files deleted",
                    color: "green",
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

// TODO: Maybe need for empty bin
// eslint-disable-next-line @typescript-eslint/no-unused-vars
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
