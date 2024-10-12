import { useForm } from "@inertiajs/react";
import { Button, Flex, Group, Modal, Text } from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";
import { notifications } from "@mantine/notifications";
import { IconFolderSymlink } from "@tabler/icons-react";
import axios from "axios";
import { DataTable } from "mantine-datatable";
import React, { FormEventHandler, useEffect, useState } from "react";
import ItemIcon from "@/Modules/Item/Components/ItemIcon";

interface IProps {
    ids?: string[];
}

interface IFormProps {
    isOpened: boolean;
    close: () => void;
    file_id?: string[];
}

const MoveFileModal: React.FC<IFormProps> = ({ isOpened, close, file_id }) => {
    const [folderContents, setFolderContents] = useState([]);
    // const [selectedDestination, setSelectedDestination] = useState(null);

    const { data, post, processing } = useForm({
        file_id: "",
        destination_id: "",
    });

    // Load initial folder contents when the modal opens
    useEffect(() => {
        if (isOpened) {
            loadFolderContents(1, "1"); // Replace "root_id" with your actual root ID
        }
    }, [isOpened]);

    const handleMove: FormEventHandler = (e) => {
        e.preventDefault();

        if (file_id) {
            data.file_id = file_id[0];
        }

        post(route("file.move"), {
            onSuccess: () => {
                close();
                notifications.show({
                    message: "Files moved successfully",
                    color: "green",
                });
            },
            onError: () => {
                notifications.show({
                    message: "Something went wrong",
                    color: "red",
                });
            },
        });
    };

    const loadFolderContents = (is_folder: number, folderId: string) => {
        if (!is_folder) {
            return;
        }

        axios
            .get(`/api/folder/${folderId}/contents`)
            .then((response) => {
                setFolderContents(response.data.contents);
                data.destination_id = folderId; // Set the current folder as the destination
            });
    };

    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={
                <Text fw="bold" size="lg">
                    Move File
                </Text>
            }
            size={550}
        >
            <form onSubmit={handleMove}>
                <DataTable
                    textSelectionDisabled
                    columns={[
                        {
                            accessor: "name",
                            render: ({ mime, is_folder, name }) => (
                                <Group align="center" gap={12}>
                                    <ItemIcon mime={mime} isFolder={is_folder} />
                                    <span>{name}</span>
                                </Group>
                            ),
                        },
                    ]}
                    records={folderContents}
                    customRowAttributes={({ is_folder, id }) => ({
                        onDoubleClick: (e: MouseEvent) => {
                            if (e.button === 0) {
                                loadFolderContents(is_folder, id);
                            }
                        },
                    })}
                    highlightOnHover
                />

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={close}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing}>
                        Save
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

const MoveButton: React.FC<IProps> = ({ ids }) => {
    const [moveFilesOpened, { open: openmoveFiles, close: closemoveFiles }] = useDisclosure(false);

    return (
        <>
            <Button
                variant="subtle"
                color="dark.3"
                leftSection={<IconFolderSymlink size={18} />}
                type="submit"
                onClick={openmoveFiles}
            >
                Move
            </Button>

            <MoveFileModal isOpened={moveFilesOpened} close={closemoveFiles} file_id={ids} />
        </>
    );
};

export default MoveButton;
