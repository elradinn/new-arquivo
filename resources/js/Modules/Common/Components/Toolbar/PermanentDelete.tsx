import React, { FormEventHandler } from "react";
import { Button, Flex, Modal, Text } from "@mantine/core";
import { useForm, usePage } from "@inertiajs/react";
import { IconTrash } from "@tabler/icons-react";
import { PageProps } from "@/types";
import { useDisclosure } from "@mantine/hooks";
import { notifications } from "@mantine/notifications";

interface RestoreFilesProps {
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

const PermanentDeleteForm: React.FC<DeleteModalProps> = ({
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

        destroy(route("file.deleteForever"), {
            onSuccess: () => {
                close();
                notifications.show({
                    message: "Files deleted permanently",
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
                    Restore Files
                </Text>
            }
            size={550}
        >
            <form onSubmit={deleteFilesSubmit}>
                <Text c="dimmed">Permanently delete selected files?</Text>

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
                        Confirm
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

// TODO: Maybe need for empty bin again?
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const PermanentDeleteButton: React.FC<RestoreFilesProps> = ({ all, ids }) => {
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
                Delete Forever
            </Button>

            <PermanentDeleteForm
                isOpened={deleteFilesOpened}
                close={closeDeleteFiles}
                deleteAll={false}
                deleteIds={ids}
            />
        </>
    );
};

export default PermanentDeleteButton;
