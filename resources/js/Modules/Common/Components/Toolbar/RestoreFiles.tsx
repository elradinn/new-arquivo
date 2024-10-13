import React, { FormEventHandler } from "react";
import { Button, Flex, Modal, Text } from "@mantine/core";
import { useForm } from "@inertiajs/react";
import { IconRestore } from "@tabler/icons-react";
import { useDisclosure } from "@mantine/hooks";
import { notifications } from "@mantine/notifications";
import { RestoreTrashedItemsData } from "@/Modules/Trash/Types/RestoreTrashedItemsData";

interface RestoreFilesProps {
    all: boolean;
    ids?: string[];
}

interface RestoreModalProps {
    isOpened: boolean;
    close: () => void;
    restoreAll?: boolean;
    restoreIds?: string[];
}

const RestoreFilesForm: React.FC<RestoreModalProps> = ({
    isOpened,
    close,
    restoreIds,
}) => {
    const {
        data,
        post,
        processing,
    } = useForm<RestoreTrashedItemsData>({
        ids: [],
    });

    const restoreFilesSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        data.ids = restoreIds || [];

        post(route("trash.restore"), {
            onSuccess: () => {
                close();
                notifications.show({
                    message: "Files restored successfully",
                    color: "green",
                });
            },
            onError: (errors) => {
                let message = "";

                if (Object.keys(errors).length > 0) {
                    message = errors[Object.keys(errors)[0]];
                } else {
                    message = "Error during file restoration. Please try again later.";
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
                    Restore Files
                </Text>
            }
            size={550}
        >
            <form onSubmit={restoreFilesSubmit}>
                <Text c="dimmed">Restore selected files?</Text>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="subtle" onClick={close} color="gray">
                        Cancel
                    </Button>

                    <Button
                        ml={12}
                        type="submit"
                        loading={processing}
                        color="green"
                    >
                        Confirm Restore
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

const RestoreFilesButton: React.FC<RestoreFilesProps> = ({ all, ids }) => {
    const [
        restoreFilesOpened,
        { open: openRestoreFiles, close: closeRestoreFiles },
    ] = useDisclosure(false);

    return (
        <>
            <Button
                variant="subtle"
                color="green"
                leftSection={<IconRestore size={18} />}
                onClick={openRestoreFiles}
            >
                Restore
            </Button>

            <RestoreFilesForm
                isOpened={restoreFilesOpened}
                close={closeRestoreFiles}
                restoreAll={false}
                restoreIds={ids}
            />
        </>
    );
};

export default RestoreFilesButton;