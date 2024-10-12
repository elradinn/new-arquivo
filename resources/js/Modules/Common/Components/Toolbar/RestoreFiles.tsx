import React, { FormEventHandler } from "react";
import { Button, Flex, Modal, Text } from "@mantine/core";
import { useForm, usePage } from "@inertiajs/react";
import { IconRestore } from "@tabler/icons-react";
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

const RestoreFilesForm: React.FC<DeleteModalProps> = ({
    isOpened,
    close,
    deleteAll,
    deleteIds,
}) => {
    const { data, post, processing } = useForm<FormData>({
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

        post(route("file.restore"), {
            onSuccess: () => {
                close();
                notifications.show({
                    message: "Files restored",
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
                <Text c="dimmed">Restore selected files?</Text>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="subtle" onClick={close} color="gray">
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing}>
                        Restore
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

// TODO: Maybe need for restore all files?
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const RestoreFilesButton: React.FC<RestoreFilesProps> = ({ all, ids }) => {
    const [
        deleteFilesOpened,
        { open: openDeleteFiles, close: closeDeleteFiles },
    ] = useDisclosure(false);

    return (
        <>
            <Button
                variant="subtle"
                color="dark.3"
                leftSection={<IconRestore size={18} />}
                onClick={openDeleteFiles}
            >
                Restore
            </Button>

            <RestoreFilesForm
                isOpened={deleteFilesOpened}
                close={closeDeleteFiles}
                deleteAll={false}
                deleteIds={ids}
            />
        </>
    );
};

export default RestoreFilesButton;
